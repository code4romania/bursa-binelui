<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Championship;
use function PHPUnit\Framework\throwException;

class ChampionshipObserver
{
    public function creating(Championship $championship): void
    {
        $championship->slug = \Str::slug($championship->name);
        if ($championship->is_current) {
            Championship::query()->update(['is_current' => false]);
        }
    }

    /**
     * Handle the Championship "created" event.
     */
    public function created(Championship $championship): void
    {
        $championship->stages()->create([
            'name' => 'Stage 1',
            'is_current' => true,
            'start_date' => $championship->start_date,
        ]);
    }

    public function updating(Championship $championship): void
    {
        $championship->slug = \Str::slug($championship->name);
        if ($championship->is_current) {
            Championship::query()->update(['is_current' => false]);
        }
    }

    /**
     * Handle the Championship "updated" event.
     */
    public function updated(Championship $championship): void
    {
        //
    }

    /**
     * Handle the Championship "deleted" event.
     */
    public function deleted(Championship $championship): void
    {
        if ($championship->has('stages.projects')) {
            throwException(new \Exception('Cannot delete championship with stages and projects'));
        }
    }

    /**
     * Handle the Championship "restored" event.
     */
    public function restored(Championship $championship): void
    {
        //
    }

    /**
     * Handle the Championship "force deleted" event.
     */
    public function forceDeleted(Championship $championship): void
    {
        //
    }
}
