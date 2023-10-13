<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasCounties;
use App\Concerns\HasVolunteers;
use App\Enums\ProjectStatus;
use App\Traits\HasProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Vite;
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
    use HasCounties;
    use HasVolunteers;
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
        'is_national',
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
        'is_national' => 'boolean',
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

        $this->addMediaCollection('gallery');
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
        return $this->morphToMany(ProjectCategory::class, 'model', 'model_has_project_categories')
            ->withTimestamps();
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
        if ($this->target_budget == 0) {
            return 0;
        }

        return min(100, $this->total_donations / $this->target_budget * 100);
    }

    public function getActiveAttribute(): bool
    {
        return $this->status == ProjectStatus::approved;
    }

    public function getIsPendingAttribute(): bool
    {
        return $this->status == ProjectStatus::pending;
    }

    public function getIsDraftAttribute(): bool
    {
        return $this->status == ProjectStatus::draft;
    }

    public function getIsPeriodActiveAttribute(): bool
    {
        return $this->start->isPast() && $this->end->isFuture();
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status == ProjectStatus::approved
            && $this->start->isPast()
            && $this->end->isFuture();
    }

    public function getCanBeArchivedAttribute(): bool
    {
        return $this->status == ProjectStatus::approved
            && now()->subDays(30)->gte($this->end);
    }

    public function getIsEndingSoonAttribute(): bool
    {
        if (empty($this->end)) {
            return false;
        }

        return $this->end->diffInDays(today()) <= 5;
    }
}
