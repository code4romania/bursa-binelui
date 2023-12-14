<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasLocation;
use App\Concerns\HasSlug;
use App\Enums\ProjectStatus;
use App\Traits\HasProjectStatus;
use Embed\Embed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Vite;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BCRProject extends Model implements HasMedia
{
    use HasFactory;
    use HasLocation;
    use InteractsWithMedia;
    use HasProjectStatus;
    use HasSlug;

    protected $table = 'bcr_projects';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
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
        'status' => ProjectStatus::class,
    ];

    protected $with = [
        'county', 'category',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('preview')
            ->useDisk(config('filesystems.default_public'))
            ->useFallbackUrl(Vite::image('placeholder.png'))
            ->singleFile()
            ->registerMediaConversions(function () {
                $this
                    ->addMediaConversion('preview')
                    ->fit(Manipulations::FIT_CONTAIN, 300, 300);
            });

        $this->addMediaCollection('gallery')
            ->useDisk(config('filesystems.default_public'))
            ->registerMediaConversions(function () {
                $this
                    ->addMediaConversion('preview')
                    ->fit(Manipulations::FIT_CONTAIN, 300, 300);
            });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function getEmbeddedVideosAttribute(): array
    {
        return collect($this->videos)
            ->pluck('link')
            ->map(
                fn (string $videoUrl) => Cache::remember(
                    'video-' . hash('sha256', $videoUrl),
                    MONTH_IN_SECONDS,
                    fn () => rescue(fn () => (new Embed)->get($videoUrl)->code, '', false)
                )
            )
            ->filter()
            ->all();
    }

    //TODO MOVE IN TRAIT
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }
        $search = trim($search);
        $search = strip_tags($search);

        return $query->where('name', 'like', "%{$search}%");
    }
}
