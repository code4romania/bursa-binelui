<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BadgeType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'type',
    ];

    protected $casts = [
        'type' => BadgeType::class,
    ];

    protected $appends = [
        'image',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->useDisk(config('filesystems.default_public'))
            ->useFallbackUrl(Vite::asset('resources/images/badge.png'))
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CROP, 300, 300);
            });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(BadgeUser::class)
            ->orderByPivot('allocated_at', 'desc');
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)
            ->using(BadgeOrganization::class)
            ->orderByPivot('allocated_at', 'desc');
    }

    public function getImageAttribute(): string
    {
        return $this->getFirstMediaUrl(conversionName: 'thumb');
    }

    public function badgeCategory(): BelongsTo
    {
        return $this->belongsTo(BadgeCategory::class);
    }
}
