<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Builder;

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

    public function isRejected(): bool
    {
        return $this->status === ProjectStatus::rejected;
    }

    public function scopeWhereIsPending(Builder $query): Builder
    {
        return $query->where('status', ProjectStatus::pending);
    }

    public function scopeWhereIsApproved(Builder $query): Builder
    {
        return $query->where('status', ProjectStatus::approved);
    }

    public function scopeWhereIsRejected(Builder $query): Builder
    {
        return $query->where('status', ProjectStatus::rejected);
    }

    public function scopeWhereIsPublished(Builder $query): Builder
    {
        return $query->whereIsApproved()->whereNull('archived_at');
    }

    public function scopeWhereIsOpen(Builder $query): Builder
    {
        return $query->whereIsPublished()
            ->whereHas('organization', fn (Builder $query) => $query->whereHasEuPlatesc())
            ->whereDate('start', '<=', now())
            ->whereDate('end', '>=', now());
    }

    public function scopeWhereStartsSoon(Builder $query): Builder
    {
        return $query->whereIsPublished()
            ->whereDate('start', '>=', now())
            ->orderBy('start');
    }

    public function scopeWhereIsDraft(Builder $query): Builder
    {
        return $query->where('status', ProjectStatus::draft);
    }

    public function scopeStatusIs(Builder $query, $status): Builder
    {
        return match ($status) {
            'draft' => $query->whereIsDraft(),
            'pending' => $query->whereIsPending(),
            'approved' => $query->whereIsApproved(),
            'rejected' => $query->whereIsRejected(),
            'published' => $query->whereIsPublished(),
            'open' => $query->whereIsOpen(),
            'starts_soon' => $query->whereStartsSoon(),
            default => $query,
        };
    }
}
