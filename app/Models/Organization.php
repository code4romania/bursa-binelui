<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasCounties;
use App\Concerns\HasVolunteers;
use App\Concerns\LogsActivityForApproval;
use App\Enums\OrganizationStatus;
use App\Enums\ProjectStatus;
use App\Traits\HasActivityDomain;
use App\Traits\HasOrganizationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Vite;
use Spatie\Activitylog\LogOptions;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Organization extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasActivityDomain;
    use HasCounties;
    use HasVolunteers;
    use HasOrganizationStatus;
    use LogsActivityForApproval;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cif',
        'description',
        'street_address',
        'contact_person',
        'contact_phone',
        'contact_email',
        'website',
        'accepts_volunteers',
        'why_volunteer',
        'status',
        'status_updated_at',
        'eu_platesc_merchant_id',
        'eu_platesc_private_key',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'status_updated_at' => 'datetime',
        'accepts_volunteers' => 'boolean',
        'eu_platesc_merchant_id' => 'encrypted',
        'eu_platesc_private_key' => 'encrypted',
    ];

    public array $requiresApproval = [
        'name',
        'cif',
        'street_address',
        'statute',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->without('organization');
    }

    public function donations()
    {
        return $this->hasManyThrough(Donation::class, Project::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->useFallbackUrl(Vite::image('placeholder.png'))
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('preview')
                    ->fit(Manipulations::FIT_CONTAIN, 300, 300)
                    ->nonQueued();
            });

        $this->addMediaCollection('statute')
            ->singleFile();

        $this->addMediaCollection('statute_pending');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function activityDomains(): BelongsToMany
    {
        return $this->belongsToMany(ActivityDomain::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * Scope a query to include the searched text.
     */
    public function scopeSearch(Builder $query, string $searchedText): Builder
    {
        return $query
            ->orWhere('name', 'LIKE', "%{$searchedText}%")
            ->orWhere('description', 'LIKE', "%{$searchedText}%")
            ->orWhere('contact_person', 'LIKE', "%{$searchedText}%")
            ->orWhere('website', 'LIKE', "%{$searchedText}%");
    }

    public function scopeWhereAcceptsVolunteers(Builder $query): Builder
    {
        return $query->where('accepts_volunteers', true);
    }

    public function scopeWhereDoesntAcceptVolunteers(Builder $query): Builder
    {
        return $query->where('accepts_volunteers', false);
    }

    public function scopeWhereHasProjects(Builder $query): Builder
    {
        return $query->whereHas('projects');
    }

    public function scopeWhereDoesntHaveProjects(Builder $query): Builder
    {
        return $query->whereDoesntHave('projects');
    }

    public function scopeWhereHasActiveProjects(Builder $query): Builder
    {
        return $query->whereRelation('projects', 'status', ProjectStatus::active);
    }

    public function scopeWhereDoesntHaveActiveProjects(Builder $query): Builder
    {
        return $query->whereRelation('projects', 'status', '!=', ProjectStatus::active);
    }

    public function scopeWhereHasEuPlatesc(Builder $query): Builder
    {
        return $query->whereNotNull('eu_platesc_merchant_id')
            ->whereNotNull('eu_platesc_private_key');
    }

    public function scopeWhereDoesntHaveEuPlatesc(Builder $query): Builder
    {
        return $query->whereNull('eu_platesc_merchant_id')
            ->orWhereNull('eu_platesc_private_key');
    }

    public function scopeWhereHasDonations(Builder $query): Builder
    {
        return $query->whereHas('projects.donations');
    }

    public function scopeWhereDoesntHaveDonations(Builder $query): Builder
    {
        return $query->whereDoesntHave('projects.donations');
    }

    public function EuPlatescIsActive(): bool
    {
        return $this->eu_platesc_merchant_id !== null && $this->eu_platesc_private_key !== null;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function markAsApproved(): bool
    {
        return $this->update([
            'status' => OrganizationStatus::approved,
            'status_updated_at' => $this->freshTimestamp(),
        ]);
    }

    public function markAsRejected(?string $reason = null): void
    {
        $this->update([
            'status' => OrganizationStatus::rejected,
            'status_updated_at' => $this->freshTimestamp(),
        ]);

        $this->tickets()->create([
            'subject' => __('organization.ticket_rejected.subject'),
            'content' => $reason,
            'user_id' => auth()->user()->id,
        ]);
        $this->projects->each->markAsRejected();
    }

    public function markAsPending(): bool
    {
        return $this->update([
            'status' => OrganizationStatus::pending,
        ]);
    }
}
