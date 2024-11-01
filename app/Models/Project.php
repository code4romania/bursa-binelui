<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasCounties;
use App\Concerns\HasSlug;
use App\Concerns\HasVolunteers;
use App\Concerns\LogsActivityForApproval;
use App\Enums\EuPlatescStatus;
use App\Enums\ProjectStatus;
use App\Traits\HasProjectStatus;
use Embed\Embed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;
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
    use HasSlug;
    use LogsActivity;
    use LogsActivityForApproval;

    protected $fillable = [
        'name',
        'description',
        'organization_id',
        'target_budget',
        'status',
        'scope',
        'reason_to_donate',
        'archived_at',
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
        'counties',
        'categories',
    ];

    protected static function booted()
    {
        static::addGlobalScope('total_amount', function (Builder $query) {
            $query
                ->withSum(['donations as total_donations' => function (Builder $query) {
                    $query->where('status', EuPlatescStatus::CHARGED);
                }], 'amount')
                ->withCount(['donations as approved_donations_count' => function (Builder $query) {
                    $query->where('status', EuPlatescStatus::CHARGED);
                }]);
        });
    }

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

        $this->addMediaCollection('gallery')
            ->useDisk(config('filesystems.default_public'))
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('preview')
                    ->fit(Manipulations::FIT_CONTAIN, 300, 300);
            });
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

    public function tickets(): HasManyThrough
    {
        return $this->hasManyThrough(Ticket::class, Organization::class);
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

    public array $requiresApproval = [
        'name',
        'target_budget',
        'start',
        'end',
    ];

    public function getCoverImageAttribute(): string
    {
        return $this->getFirstMediaUrl('project_files', 'preview') ?? '';
    }

    public function getPercentageAttribute(): float
    {
        if ($this->target_budget == 0) {
            return 0;
        }

        return min(100, round($this->total_donations / $this->target_budget * 100, 2));
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
            && now()->subDays(30)->gte($this->end) && ! $this->isArchived();
    }

    public function getIsEndingSoonAttribute(): bool
    {
        if (empty($this->end)) {
            return false;
        }

        return $this->end->diffInDays(today()) <= 5;
    }

    public function getIsRejectedAttribute(): bool
    {
        return $this->status == ProjectStatus::rejected;
    }

    public function getVisibleStatusAttribute(): string
    {
        if ($this->isStartingSoon()) {
            return 'starting_soon';
        }
        if ($this->isOpen()) {
            return 'open';
        }
        if ($this->isClose()) {
            return 'close';
        }
        if ($this->isArchived()) {
            return 'archived';
        }

        return $this->status->value;
    }

    public function markAsApproved(): bool
    {
        $slug = Str::slug($this->name);

        $count = self::whereRaw("slug RLIKE '^{$this->slug}(-[0-9]+)?$'")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $this->activities->map(fn (Activity $activity) => $activity->approve());

        return $this->update([
            'status' => ProjectStatus::approved,
            'status_updated_at' => $this->freshTimestamp(),
            'slug' => $slug,
        ]);
    }

    public function markAsRejected(?string $reason = null): void
    {
        $this->update([
            'status' => ProjectStatus::rejected,
            'status_updated_at' => $this->freshTimestamp(),
        ]);

        if ($reason) {
            $this->organization->tickets()->create([
                'subject' => __('project.ticket_rejected.subject'),
                'content' => $reason,
                'user_id' => auth()->user()->id,
            ]);
        }
    }

    public function getEmbeddedVideosAttribute(): array
    {
        return collect($this->videos)
            ->pluck('url')
            ->filter()
            ->map(
                fn (string $videoUrl) => Cache::remember(
                    'video-' . hash('sha256', $videoUrl),
                    MONTH_IN_SECONDS,
                    fn () => rescue(fn () => (new Embed)->get($videoUrl)->code, report: false)
                )
            )
            ->filter()
            ->all();
    }

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
