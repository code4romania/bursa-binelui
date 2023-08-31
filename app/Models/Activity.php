<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity as BaseActivity;

class Activity extends BaseActivity
{
    public const UPDATED_AT = null;

    protected $casts = [
        'properties' => 'collection',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    protected $with = [
        'causer', 'subject',
    ];

    protected static function booted()
    {
        static::addGlobalScope('latest', function (Builder $query) {
            return $query->latest();
        });
    }

    public function scopeBetweenDates(Builder $query, ?string $from = null, ?string $until = null): Builder
    {
        return $query
            ->when($from, function (Builder $query, string $date) {
                $query->whereDate('created_at', '>=', $date);
            })
            ->when($until, function (Builder $query, string $date) {
                $query->whereDate('created_at', '<=', $date);
            });
    }

    public function getChangedFieldAttribute(): ?string
    {
        return $this->properties->keys()->first();
    }

    public function getChangedFieldOldValueAttribute(): ?string
    {
        return data_get($this->properties, $this->changed_field . '.old');
    }

    public function getChangedFieldNewValueAttribute(): ?string
    {
        return data_get($this->properties, $this->changed_field . '.new');
    }

    public function getStatusAttribute(): ?string
    {
        if ($this->isApproved()) {
            return __('activity.status.approved');
        }

        if ($this->isRejected()) {
            return __('activity.status.rejected');
        }

        return null;
    }

    public function isPending(): bool
    {
        return ! $this->isApproved() && ! $this->isRejected();
    }

    public function isApproved(): bool
    {
        return null !== $this->approved_at;
    }

    public function isRejected(): bool
    {
        return null !== $this->rejected_at;
    }

    public function scopeUserPendingChanges(Builder $query, int $recordId, string $modelClass): Builder
    {
        return $query->where('subject_id', $recordId)
            ->where('subject_type', $modelClass)
            ->where('approved_at', null)
            ->where('rejected_at', null)
            ->where('log_name', 'pending');
//                ->whereJsonContains('properties', $attribute)
    }

    public function approve(): void
    {
        if ($this->isRejected()) {
            return;
        }

        activity()->withoutLogs(function () {
            $this->properties->each(function ($value, $key) {
                $this->subject->setAttribute($key, $value['new']);
            });

            $this->subject->save();

            $this->update([
                'approved_at' => now(),
            ]);
        });
    }

    public function reject(): void
    {
        if ($this->isApproved()) {
            return;
        }

        $this->update([
            'rejected_at' => now(),
        ]);
    }
}
