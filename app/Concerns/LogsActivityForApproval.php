<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\EventLogBag;
use Spatie\Activitylog\Traits\LogsActivity as SpatieLogsActivity;

trait LogsActivityForApproval
{
    use SpatieLogsActivity;

    public function saveForApproval(): void
    {
        $changes = collect($this->getDirty())
            ->map(fn ($value, $key) => [
                'old' => $this->getOriginal($key),
                'new' => $value,
            ]);

        if ($changes->isEmpty()) {
            return;
        }
        $this->removePendingChangesForTheSameAttribute($this->getDirty());

        $eventName = 'updated';

        $this->activitylogOptions = $this->getActivitylogOptions();

        $description = $this->getDescriptionForEvent($eventName);

        $logName = 'pending';

        // Submitting empty description will cause place holder replacer to fail.
        if ($description == '') {
            return;
        }

        // User can define a custom pipelines to mutate, add or remove from changes
        // each pipe receives the event carrier bag with changes and the model in
        // question every pipe should manipulate new and old attributes.
        $event = app(Pipeline::class)
            ->send(new EventLogBag($eventName, $this, $changes->all(), $this->activitylogOptions))
            ->through(static::$changesPipes)
            ->thenReturn();

        foreach ($event->changes as $key => $value) {
            static::actuallyLog($logName, $eventName, $this, $event->changes, $description);
        }

        // Reset log options so the model can be serialized.
        $this->activitylogOptions = null;
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

    public function approveChanges($changesId): void
    {
        /** @var Activity $changes */
        $changes = Activity::find($changesId);
        foreach ($changes->properties as $key => $change) {
            $this->setAttribute($key, $change['new']);
        }
        $changes->setApproved();
        $this->save();
        //TODO send email
    }

    public function rejectChanges($changesId): void
    {
        /** @var Activity $changes */
        $changes = Activity::find($changesId);
        foreach ($changes->properties as $key => $change) {
            $this->setAttribute($key, $change['old']);
        }
        $changes->setRejected();
        $this->save();
        //TODO send email
    }

    public function removePendingChangesForTheSameAttribute($changes): void
    {
        $attributes = collect($changes)->keys();
        foreach ($attributes as $attribute) {
            $changes = Activity::userPendingChanges($this->id,\get_class($this))->get();
            foreach ($changes as $change) {
                if ($change->properties->keys()->contains($attribute)) {
                    $change->delete();
                }
            }
        }
    }
}
