<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasSlug;
use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Vite;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasSlug;
    use HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active',
        'article_category_id',
        'author',
    ];

    public $translatable = [
        'title',
        'slug',
        'content',
        'author',
    ];

    protected $with = [
        'category',
        'media',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->useFallbackUrl(Vite::image('placeholder.png'))
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CONTAIN, 400, 200)
                    ->nonQueued();

                $this
                    ->addMediaConversion('large')
                    ->fit(Manipulations::FIT_CONTAIN, 1200, 600)
                    ->nonQueued();
            });

        $this->addMediaCollection('gallery')
            ->useFallbackUrl(Vite::image('placeholder.png'))
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CONTAIN, 400, 200)
                    ->nonQueued();

                $this
                    ->addMediaConversion('large')
                    ->fit(Manipulations::FIT_CONTAIN, 1200, 600)
                    ->nonQueued();
            });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id', 'id');
    }

    public function scopeWherePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
