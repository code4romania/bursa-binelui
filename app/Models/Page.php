<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasSlug;
use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;
    use HasSlug;
    use HasTranslations;

    public $translatable = [
        'title',
        'slug',
        'description',
        'content',
    ];

    public function edition(): HasMany
    {
        return $this->hasMany(Edition::class);
    }
}
