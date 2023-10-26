<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\OrganizationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait HasOrganizationStatus
{
    public function initializeHasOrganizationStatus()
    {
        $this->casts['status'] = OrganizationStatus::class;
    }

    public function isPending(): bool
    {
        return $this->status === OrganizationStatus::pending;
    }

    public function isApproved(): bool
    {
        return $this->status === OrganizationStatus::approved;
    }

    public function isRejected(): bool
    {
        return $this->status === OrganizationStatus::rejected;
    }

    public function scopeStatus(Builder $query, array|string|Collection|OrganizationStatus $statuses): void
    {
        $query->whereIn('status', collect($statuses));
    }

    public function scopeIsPending(Builder $query): void
    {
        $query->where('status', OrganizationStatus::pending);
    }

    public function scopeIsApproved(Builder $query): void
    {
        $query->where('status', OrganizationStatus::approved);
    }

    public function scopeIsRejected(Builder $query): void
    {
        $query->where('status', OrganizationStatus::rejected);
    }
}
