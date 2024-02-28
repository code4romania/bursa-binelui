<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class County extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lat',
        'long',
    ];

    public $timestamps = false;

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'model', 'model_has_counties', 'model_id');
    }
}
