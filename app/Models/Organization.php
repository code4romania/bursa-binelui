<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasActivityDomain;
use App\Traits\HasOrganizationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;
    use HasActivityDomain;
    use HasOrganizationStatus;

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
    ];

    protected $with = ['counties', 'activityDomains', 'projects'];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->without('organization');
    }

    /**
     * Get the users or the organization.
     */
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

    /**
     * Scope a query to include the searched text.
     */
    public function scopeSearch(Builder $query, string $searchedText): void
    {
        $query->orWhere('name', 'LIKE',"%{$searchedText}%");
        $query->orWhere('description', 'LIKE', "%{$searchedText}%");
        $query->orWhere('contact_person', 'LIKE', "%{$searchedText}%");
        $query->orWhere('website', 'LIKE', "%{$searchedText}%");
    }
}
