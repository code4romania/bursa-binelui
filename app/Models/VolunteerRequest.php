<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\VolunteerStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class VolunteerRequest extends MorphPivot
{
    public $incrementing = true;

    protected $table = 'model_has_volunteers';

    protected $fillable = [
        'status',
    ];

    protected $casts = [
        'status' => VolunteerStatus::class,
    ];

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeWhereBelongsToOrganization(Builder $query, int $organizationId): Builder
    {
        return $query
            ->whereMorphRelation('model', Organization::class, 'id', $organizationId)
            ->orWhereMorphRelation('model', Project::class, 'organization_id', $organizationId)
            ->with(['model' => function (MorphTo $morphTo) {
                $morphTo->constrain([
                    Project::class => fn (Builder $query) => $query->select(['id', 'name', 'organization_id']),
                    Organization::class => fn (Builder $query) => $query->select(['id', 'name']),
                ]);
            }]);
    }

    public function markAsApproved(): bool
    {
        return $this->update([
            'status' => VolunteerStatus::APPROVED,
        ]);
    }

    public function markAsRejected(): bool
    {
        return $this->update([
            'status' => VolunteerStatus::REJECTED,
        ]);
    }
}
