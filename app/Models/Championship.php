<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Championship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_current',
        'needs_approval',
        'description',
        'start_date',
        'end_date',
        'registration_start_date',
        'registration_end_date',
    ];

    protected $appends = [
      'active_stage',
    ];

    public function stages(): HasMany
    {
        return $this->hasMany(ChampionshipStage::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCurrent($query): mixed
    {
        return $query->where('is_current', true);
    }

    public function activeStage(): ChampionshipStage | null
    {
        return $this->stages()->where('is_current', true)->first();
    }

    public function getActiveStageAttribute(): ChampionshipStage | null
    {
        return $this->activeStage();
    }

    public function projects(): HasManyThrough
    {
        return $this->hasManyThrough(Project::class, ChampionshipStageProject::class, 'championship_id', 'id', 'id', 'project_id');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(ChampionshipTestimonial::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
