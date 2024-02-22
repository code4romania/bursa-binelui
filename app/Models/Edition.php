<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Edition extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'short_description',
        'start_date',
        'end_date',
    ];

    public $preventsLazyLoading = true;

    public function edition_categories(): HasMany
    {
        return $this->hasMany(EditionCategories::class);
    }

    public function faq(): HasMany
    {
        return $this->hasMany(EditionFaq::class);
    }

    public function gales(): HasMany
    {
        return $this->hasMany(Gala::class);
    }

    public function prize(): HasMany
    {
        return $this->hasMany(Prize::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function article_category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class);
    }
}
