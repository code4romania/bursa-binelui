<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Vite;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Badge extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->useFallbackUrl(Vite::asset('resources/images/badge.png'))
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('default')
                    ->fit(Manipulations::FIT_CROP, 300, 300)
                    ->nonQueued();
            });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(BadgeUser::class)
            ->orderByPivot('allocated_at', 'desc');
    }

    public function getImageAttribute(): string
    {
        return $this->getFirstMediaUrl();
    }
}
