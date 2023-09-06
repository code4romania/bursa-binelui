<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Volunteer;
use App\Models\VolunteerRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasVolunteers
{
    public function volunteers(): MorphToMany
    {
        return $this->morphToMany(Volunteer::class, 'model', 'model_has_volunteers', 'model_id')
            ->using(VolunteerRequest::class)
            ->withTimestamps()
            ->withPivot('status');
    }

    public function scopeWhereHasVolunteers(Builder $query): Builder
    {
        return $query->whereHas('volunteers');
    }

    public function scopeWhereDoesntHaveVolunteers(Builder $query): Builder
    {
        return $query->whereDoesntHave('volunteers');
    }
}
