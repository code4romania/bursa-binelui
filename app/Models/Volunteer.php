<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'model', 'model_has_volunteers')
            ->using(VolunteerRequest::class)
            ->withTimestamps()
            ->withPivot('status');
    }

    public function organizations(): MorphToMany
    {
        return $this->morphedByMany(Organization::class, 'model', 'model_has_volunteers')
            ->using(VolunteerRequest::class)
            ->withTimestamps()
            ->withPivot('status');
    }

    /** @deprecated */
    public function scopeWhereBelongsToOrganization(Builder $query, int $organizationId): Builder
    {
        return $query
            ->whereHas(
                'organizations',
                fn ($query) => $query->where('organizations.id', $organizationId)
            )
            ->orWhereHas(
                'projects',
                fn ($query) => $query->where('organization_id', $organizationId)
            );
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
