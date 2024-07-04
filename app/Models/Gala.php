<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToEdition;
use App\Concerns\HasCounties;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Vite;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class Gala extends Model implements HasMedia
{
    use HasFactory;
    use HasCounties;
    use InteractsWithMedia;
    use BelongsToEdition;
    use BelongsToThroughTrait;

    protected $fillable = [
        'title',
        'edition_id',
        'start_date',
        'end_date',
        'start_sign_up',
        'end_sign_up',
        'start_validate',
        'end_validate',
        'start_evaluation',
        'end_evaluation',
        'start_gale',
        'location',
    ];

    protected $with = ['edition', 'counties'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_sign_up' => 'date',
        'end_sign_up' => 'date',
        'start_validate' => 'date',
        'end_validate' => 'date',
        'start_evaluation' => 'date',
        'end_evaluation' => 'date',
        'start_gale' => 'date',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('preview')
            ->useDisk(config('filesystems.default_public'))
            ->useFallbackUrl(Vite::image('placeholder.png'))
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('preview')
                    ->fit(Manipulations::FIT_CONTAIN, 300, 300);
            });
    }

    public function galaProject(): HasMany
    {
        return $this->hasMany(GalaProject::class);
    }

    public function getRegistrationIsOpenAttribute(): bool
    {
        return now()->between($this->start_sign_up, $this->end_sign_up);
    }

    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }
}
