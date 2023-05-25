<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class County extends Model
{
    use HasFactory;

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
