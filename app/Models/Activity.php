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
        if (null !== $this->rejected_at) {
            return __('activity.status.rejected');
        }

        if (null !== $this->approved_at) {
            return __('activity.status.approved');
        }

        return null;
    }
}
