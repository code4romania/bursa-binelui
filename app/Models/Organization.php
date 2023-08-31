<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\LogsActivityForApproval;
use App\Enums\OrganizationStatus;
use App\Traits\HasActivityDomain;
use App\Traits\HasOrganizationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
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

    public function counties(): BelongsToMany
    {
        return $this->belongsToMany(County::class);
    }

    public function activityDomains(): BelongsToMany
    {
        return $this->belongsToMany(ActivityDomain::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Scope a query to include the searched text.
     */
    public function scopeSearch(Builder $query, string $searchedText): void
    {
        $query->orWhere('name', 'LIKE', "%{$searchedText}%");
        $query->orWhere('description', 'LIKE', "%{$searchedText}%");
        $query->orWhere('contact_person', 'LIKE', "%{$searchedText}%");
        $query->orWhere('website', 'LIKE', "%{$searchedText}%");
    }

    public function getAdministrators(): Collection
    {
        return $this->users()
            ->onlyNGOAdmins()
            ->get();
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

    public function markAsRejected(): bool
    {
        return $this->update([
            'status' => OrganizationStatus::rejected,
            'status_updated_at' => $this->freshTimestamp(),
        ]);
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
