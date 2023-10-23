<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Vite;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BCRProject extends Model implements HasMedia
{
    use HasFactory;
    use HasLocation;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'external_articles',
        'facebook_link',
        'accepting_comments',
        'videos',
        'city_id',
        'county_id',
        'project_category_id',
        'is_national',
    ];

    protected $casts = [
        'external_links' => 'array',
        'videos' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'accepting_comments' => 'boolean',
        'is_national' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('preview')
            ->useFallbackUrl(Vite::image('placeholder.png'))
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('preview')
                    ->fit(Manipulations::FIT_CONTAIN, 300, 300)
                    ->nonQueued();
            });

        $this->addMediaCollection('gallery')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('preview')
                    ->fit(Manipulations::FIT_CONTAIN, 300, 300)
                    ->nonQueued();
            });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }
}
