<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChampionshipStageProject extends Model
{
    protected $table = 'championship_stage_project';
    use HasFactory;

    protected $with = ['project'];

    protected $fillable = [
        'championship_stage_id',
        'project_id',
        'championship_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
