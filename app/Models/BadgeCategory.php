<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BadgeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function badges(): HasMany
    {
        return $this->hasMany(Badge::class);
    }
}
