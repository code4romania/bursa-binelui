<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChampionshipStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',

    ];

    protected $withCount = [
        'projects',
    ];

    public function projects()
    {
        return $this->hasMany(ChampionshipStageProject::class);
    }

    public function championship(): BelongsTo
    {
        return $this->belongsTo(Championship::class);
    }
}
