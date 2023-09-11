<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function projects(): BelongsToMany
    {
        return $this->morphedByMany(Project::class, 'model', 'model_has_project_categories')
            ->withTimestamps();
    }
}
