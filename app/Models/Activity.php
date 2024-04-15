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

    public function scopeWherePending(Builder $query): Builder
    {
        return $query->inLog('pending')
            ->whereNull('approved_at')
            ->whereNull('rejected_at');
    }

    public function scopePendingChangesFor(Builder $query, Model $subject, array $keys = []): Builder
    {
        return $query->wherePending()
            ->forSubject($subject)
            ->when(filled($keys), function (Builder $query) use ($keys) {
                $query->where(function (Builder $query) use ($keys) {
                    foreach ($keys as $key) {
                        $query->orWhereJsonContainsKey("properties->{$key}");
                    }
                });
            });
    }

    public function getChangedFieldAttribute(): ?string
    {
        return $this->properties->keys()->first();
    }

    public function getChangedFieldOldValueAttribute(): ?string
    {
        $value = data_get($this->properties, $this->changed_field . '.old');

        return $this->getModifiedField($value);
    }

    public function getChangedFieldNewValueAttribute(): ?string
    {
        $value = data_get($this->properties, $this->changed_field . '.new');

        return $this->getModifiedField($value);
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

    public function approve(): void
    {
        if ($this->isRejected()) {
            return;
        }

        activity()->withoutLogs(function () {
            $this->properties->each(function ($value, $key) {
                $this->subject->setAttribute($key, $value['new']);
            });

            if ($this->subject instanceof Organization) {
                $value = data_get($this->properties, $this->changed_field . '.new');
                if ($this->description === 'statute') {
                    $this->subject->getMedia('statute')->map(function (Media $media) use ($value) {
                        if ($media->id != $value) {
                            $media->delete();
                        }
                    });
                    $media = Media::find($value);
                    $media->collection_name = 'statute';
                    $media->save();
                    $this->subject->media->add($media);
                } else {
                    $this->subject->save();
                }
            } else {
                $this->subject->save();
            }

            $this->update([
                'approved_at' => now(),
            ]);
        });
    }

    public function reject(?string $reason): void
    {
        if ($this->isApproved()) {
            return;
        }
        //TODO move add tickets as a relationship in project model

        $organization = $this->subject;
        if ($organization instanceof Project) {
            $organization = $this->subject->organization;
        }
        $organization->tickets()->create([
            'subject' => __('project.ticket_rejected.subject'),
            'content' => $reason,
            'user_id' => auth()->user()->id,
        ]);

        $this->update([
            'rejected_at' => now(),
        ]);
    }

    /**
     * @param  mixed         $value
     * @return string | null
     */
    public function getModifiedField(mixed $value): ?string
    {
        if ($this->description === 'statute') {
            $value = Media::find($value)?->getUrl();
        }

        if (\gettype($value) == 'boolean') {
            $value = $value ? __('field.boolean.true') : __('field.boolean.false');
        }

        return $value;
    }
}
