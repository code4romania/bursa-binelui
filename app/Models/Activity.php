<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity as BaseActivity;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        $value = data_get($this->properties, $this->changed_field . '.old');

        if ($this->description === 'statute') {
            return Media::find($value)?->getUrl();
        }

        return $value;
    }

    public function getChangedFieldNewValueAttribute(): ?string
    {
        $value = data_get($this->properties, $this->changed_field . '.new');

        if ($this->description === 'statute') {
            return Media::find($value)?->getUrl();
        }

        return $value;
    }

    public function getStatusAttribute(): ?string
    {
        if ($this->log_name === 'auto_approved') {
            return __('activity.status.auto_approved');
        }

        if ($this->isApproved()) {
            return __('activity.status.approved');
        }

        if ($this->isRejected()) {
            return __('activity.status.rejected');
        }

        return __('activity.status.pending');
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

    public function scopePendingChangesFor(Builder $query, Model $subject, array $keys = []): Builder
    {
        return $query->inLog('pending')
            ->forSubject($subject)
            ->whereNull('approved_at')
            ->whereNull('rejected_at')
            ->when(filled($keys), function (Builder $query) use ($keys) {
                $query->where(function (Builder $query) use ($keys) {
                    foreach ($keys as $key) {
                        $query->orWhereJsonContainsKey("properties->{$key}");
                    }
                });
            });
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
