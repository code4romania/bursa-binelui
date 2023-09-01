<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\EventLogBag;
use Spatie\Activitylog\Traits\LogsActivity as SpatieLogsActivity;

trait LogsActivity
{
    use SpatieLogsActivity;

    protected static function bootLogsActivity(): void
    {
        // Hook into eloquent events that only specified in $eventToBeRecorded array,
        // checking for "updated" event hook explicitly to temporary hold original
        // attributes on the model as we'll need them later to compare against.

        static::eventsToBeRecorded()->each(function ($eventName) {
            if ($eventName === 'updated') {
                static::updating(function (Model $model) {
                    $oldValues = (new static())->setRawAttributes($model->getRawOriginal());
                    $model->oldAttributes = static::logChanges($oldValues);
                });
            }

            static::$eventName(function (Model $model) use ($eventName) {
                $model->activitylogOptions = $model->getActivitylogOptions();

                if (! $model->shouldLogEvent($eventName)) {
                    return;
                }

                $changes = $model->attributeValuesToBeLogged($eventName);

                $description = $model->getDescriptionForEvent($eventName);

                $logName = $model->getLogNameToUse();

                // Submitting empty description will cause place holder replacer to fail.
                if ($description == '') {
                    return;
                }

                if ($model->isLogEmpty($changes) && ! $model->activitylogOptions->submitEmptyLogs) {
                    return;
                }

                // User can define a custom pipelines to mutate, add or remove from changes
                // each pipe receives the event carrier bag with changes and the model in
                // question every pipe should manipulate new and old attributes.
                $event = app(Pipeline::class)
                    ->send(new EventLogBag($eventName, $model, $changes, $model->activitylogOptions))
                    ->through(static::$changesPipes)
                    ->thenReturn();

                if ($eventName === 'updated' || $eventName === 'updating') {
                    foreach ($event->changes['attributes'] as $key => $value) {
                        static::actuallyLog($logName, $eventName, $model, [
                            $key => [
                                'old' => $event->changes['old'][$key],
                                'new' => $value,
                            ],
                        ], $description);
                    }
                } else {
                    static::actuallyLog($logName, $eventName, $model, $event->changes, $description);
                }

                // Reset log options so the model can be serialized.
                $model->activitylogOptions = null;
            });
        });
    }

    protected static function actuallyLog(?string $logName, string $eventName, Model $model, array $properties, string $description): void
    {
        // Actual logging
        $logger = app(ActivityLogger::class)
            ->useLog($logName)
            ->event($eventName)
            ->performedOn($model)
            ->withProperties($properties);

        if (method_exists($model, 'tapActivity')) {
            $logger->tap([$model, 'tapActivity'], $eventName);
        }

        $logger->log($description);
    }
}
