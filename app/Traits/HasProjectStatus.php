<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Builder;

trait HasProjectStatus
{
    //TODO
    //Rename wherw Is panding is approve is rejected
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

    public function isRejected(): bool
    {
        return $this->status === ProjectStatus::rejected;
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

    public function scopeWherePublished(Builder $query): Builder
    {
        return $query->whereIn('status', [ProjectStatus::active, ProjectStatus::disabled]);
    }
}
