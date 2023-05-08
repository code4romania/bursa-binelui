<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Organization extends Model
{
    use HasFactory;

    const STATUS_PENDING  ='pending';
    const STATUS_ACTIVE   = 'active';
    const STATUS_DISABLED = 'disabled';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cif',
        'logo',
        'description',
        'status_document',
        'county_id',
        'city_id',
        'street_address',
        'contact_person',
        'contact_phone',
        'contact_email',
        'website',
        'accepts_volunteers',
        'why_volunteer',
        'activity_domains',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];


    /**
     * Get the users or the organization.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }


    /**
     * Scope a query to include the searched text.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', self::STATUS_ACTIVE);
    }


    /**
     * Scope a query to include the searched text.
     */
    public function scopeSearch(Builder $query, string $searchedText): void
    {
        $query->orWhere('name', 'LIKE', '%{$searchedText}%');
        $query->orWhere('description', 'LIKE', '%{$searchedText}%');
        $query->orWhere('contact_person', 'LIKE', '%{$searchedText}%');
        $query->orWhere('website', 'LIKE', '%{$searchedText}%');
    }


    /**
     * Scope a query to include specified activity domains.
     */
    public function scopeActivityDomains(Builder $query, array $activityDomains): void
    {
        foreach ($activityDomains as $activityDomain) {
            $query->orWhere('activity_domains', 'LIKE', '%{$activityDomain}%');
        }
    }
}
