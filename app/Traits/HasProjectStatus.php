<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait HasProjectStatus
{
    public function initializeHasProjectStatus()
    {
        $this->casts['status'] = ProjectStatus::class;
    }

    public function isPending(): bool
    {
        return $this->status === ProjectStatus::pending;
    }

    public function isApproved(): bool
    {
        return $this->status === ProjectStatus::approved;
    }

    public function isDisabled(): bool
    {
        return $this->status === ProjectStatus::rejected;
    }

    public function scopeStatus(Builder $query, array|string|Collection|ProjectStatus $statuses): void
    {
        $query->whereIn('status', collect($statuses));
    }

    public function scopeIsPending(Builder $query): void
    {
        $query->where('status', ProjectStatus::pending);
    }

    public function scopeIsApproved(Builder $query): void
    {
        $query->where('status', ProjectStatus::approved);
    }

    public function scopeIsRejected(Builder $query): void
    {
        $query->where('status', ProjectStatus::rejected);
    }
}
