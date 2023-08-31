<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Activity;
use Spatie\Activitylog\ActivityLogger;
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

        Activity::pendingChangesFor($this, $changes->keys()->all())->delete();

        $eventName = 'updated';

        $description = $this->getDescriptionForEvent($eventName) ?: $eventName;

        // Actual logging
        app(ActivityLogger::class)
            ->useLog('pending')
            ->event($eventName)
            ->performedOn($this)
            ->withProperties($changes)
            ->log($description);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->flipProperties($activity);

        if (! auth()->user()->isBbAdmin() && ! auth()->user()->isBbManager()) {
            return;
        }

        activity()->disableLogging();

        if (! $activity->description) {
            $activity->description = $this->getDescriptionForEvent($eventName);
        }

        $activity->properties->each(
            fn ($values, $key) => $activity
                ->replicate()
                ->fill([
                    'properties' => [$key => $values],
                    'approved_at' => now(),
                ])
                ->save()
        );
    }

    private function flipProperties(Activity &$activity): void
    {
        $properties = [];

        foreach ($activity->properties->get('attributes', []) as $key => $value) {
            $properties[$key] = [
                'old' => data_get($activity->properties, "old.{$key}"),
                'new' => $value,
            ];
        }

        if (! empty($properties)) {
            $activity->properties = $properties;
        }
    }
}
