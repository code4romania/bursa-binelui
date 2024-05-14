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
        return ProjectStatus::pending->is($this->status);
    }

    public function isApproved(): bool
    {
        return ProjectStatus::approved->is($this->status);
    }

    public function isRejected(): bool
    {
        return ProjectStatus::rejected->is($this->status);
    }

    public function isDraft(): bool
    {
        return ProjectStatus::draft->is($this->status);
    }

    public function isPublished(): bool
    {
        return $this->isApproved() && $this->archived_at === null;
    }

    public function isOpen(): bool
    {
        return $this->isPublished() && $this->start->isPast() && $this->end->isFuture();
    }

    public function isArchived(): bool
    {
        return $this->isApproved() && ! empty($this->archived_at);
    }

    public function isStartingSoon(): bool
    {
        return $this->isPublished()
            && ! $this->end->isPast()
            && ($this->start->isFuture() || ! $this->organization->EuPlatescIsActive());
    }

    public function isClose(): bool
    {
        return $this->isPublished() && $this->end->isPast();
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

    public function scopeWhereIsClosed(Builder $query): Builder
    {
        return $query->whereIsPublished()
            ->whereDate('end', '<', now());
    }

    public function scopeWhereStartsSoon(Builder $query): Builder
    {
        return $query->whereIsPublished()
            ->whereDate('start', '>=', now())
            ->orWhere(
                fn (Builder $query) => $query->whereHas(
                    'organization',
                    fn (Builder $query) => $query->whereDoesntHaveEuPlatesc()
                )
            )
            ->orderBy('start');
    }

    public function scopeWhereIsDraft(Builder $query): Builder
    {
        return $query->whereIn('status', [ProjectStatus::draft, ProjectStatus::pending]);
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
