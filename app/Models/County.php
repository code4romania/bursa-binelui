<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class County extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'lat',
        'long',
    ];

    protected $casts = [
        'lat' => 'double',
        'long' => 'double',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'model', 'model_has_counties');
    }

    public function scopeWithWhereHasProjectsCount(Builder $query): Builder
    {
        $callback = function (Builder $query) {
            return $query
                ->withoutGlobalScope('total_amount')
                ->whereIsPublished();
        };

        return $query
            ->whereHas('projects', $callback)
            ->withCount(['projects' => $callback]);
    }
}
