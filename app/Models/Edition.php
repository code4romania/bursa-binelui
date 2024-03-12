<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Edition extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'active',
        'short_description',
        'start_date',
        'end_date',
    ];

    public function editionCategories(): HasMany
    {
        return $this->hasMany(EditionCategories::class);
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(EditionFaq::class);
    }

    public function gales(): HasMany
    {
        return $this->hasMany(Gala::class);
    }

    public function prizes(): HasMany
    {
        return $this->hasMany(Prize::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function articleCategory(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function galaProjects(): HasManyThrough
    {
        return $this->hasManyThrough(GalaProject::class, Gala::class);
    }

    public function scopeCurrentEdition(Builder $query): Builder
    {
        return $query->where('active', true);
    }
}
