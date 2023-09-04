<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProjectStatus;
use App\Traits\HasProjectStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property string $status
 */
class Project extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasProjectStatus;
    use LogsActivity;

    protected $fillable = [
        'name',
        'description',
        'organization_id',
        'target_budget',
        'status',
        'scope',
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
        'status' => ProjectStatus::class,
    ];

    protected $with = [
        'media',
        'organization',
        'donations',
        'counties',
        'categories',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * @deprecated use `wherePublished` instead
     */
    public function scopePublish(Builder $query): Builder
    {
        return $query->whereIn('status', [ProjectStatus::active, ProjectStatus::disabled]);
    }

    public function counties(): BelongsToMany
    {
        return $this->belongsToMany(County::class);
    }

    public function volunteers(): BelongsToMany
    {
        return $this->belongsToMany(Volunteer::class);
    }

    public function stages(): BelongsToMany
    {
        return $this->belongsToMany(ChampionshipStage::class);
    }

    public function championships()
    {
        return $this->hasManyThrough(Championship::class, ChampionshipStageProject::class, 'project_id', 'id', 'id', 'championship_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProjectCategory::class, 'project_category');
    }

    public function getRequiredFieldsForApproval(): array
    {
        return[
            'name',
            'description',
            'start',
            'end',
            'categories',
            'reason_to_donate',
            'beneficiaries',
        ];
    }

    public function getTotalDonationsAttribute(): int
    {
        return (int) $this->donations->sum('amount');
    }

    public function getCoverImageAttribute(): string
    {
        return $this->getFirstMediaUrl('project_files', 'preview') ?? '';
    }

    public function getPercentageAttribute(): float
    {
        return min(100, $this->total_donations / $this->target_budget * 100);
    }

    public function getActiveAttribute(): bool
    {
        return $this->status === ProjectStatus::active;
    }

    public function getIsPeriodActiveAttribute(): bool
    {
        return $this->start->isPast() && $this->end->isFuture();
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === ProjectStatus::active
            && $this->start->isPast()
            && $this->end->isFuture();
    }

    public function getIsEndingSoonAttribute(): bool
    {
        return $this->end->diffInDays(today()) <= 5;
    }
}
