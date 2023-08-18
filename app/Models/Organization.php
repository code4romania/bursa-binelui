<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use App\Traits\HasActivityDomain;
use App\Traits\HasOrganizationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
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
    use LogsActivity;

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
        'accepts_volunteers' => 'boolean',
    ];

    protected $appends = ['cover_image', 'statute_link'];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->without('organization');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
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

    public function getCoverImageAttribute(): string
    {
        return $this->getFirstMediaUrl('organizationFilesLogo', 'preview') ?? '';
    }

    public function getStatuteLinkAttribute(): string
    {
        return $this->getFirstMediaUrl('organizationFilesStatute') ?? '';
    }

    public function getAdministrator()
    {
        return $this->users()->where('role', UserRole::ngo_admin)->first();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }
}
