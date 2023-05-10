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

    public function isActive(): bool
    {
        return $this->status === OrganizationStatus::active;
    }

    public function isDisabled(): bool
    {
        return $this->status === OrganizationStatus::disabled;
    }

    public function scopeStatus(Builder $query, array|string|Collection|OrganizationStatus $statuses): void
    {
        $query->whereIn('status', collect($statuses));
    }
}
