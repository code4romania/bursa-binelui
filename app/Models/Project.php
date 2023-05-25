<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasLocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasLocation;

    protected $fillable = [
        'name',
        'description',
        'organization_id',
        'category',
        'target_budget',
        'scope',
        'county_id',
        'reason_to_donate',
        'beneficiaries',
        'start',
        'end',
        'accepting_volunteers',
        'accepting_comments',
        'videos',
        'external_links',
        'slug',
    ];

    protected $casts = [
        'videos' => 'array',
        'external_links' => 'array',
        'start' => 'date:Y-m-d',
        'end' => 'date:Y-m-d',
        'accepting_volunteers' => 'boolean',
        'accepting_comments' => 'boolean',
    ];

    protected $appends = ['total_donations', 'cover_image'];

    protected $with = ['media', 'organization', 'donations','county'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function Donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function getTotalDonationsAttribute(): int
    {
        return (int) $this->donations->sum('amount');
    }

    public function getCoverImageAttribute(): string
    {
        return $this->getFirstMediaUrl('project_files', 'preview') ?? '';
    }

    public function scopePublish(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }
}
