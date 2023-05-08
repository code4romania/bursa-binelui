<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
}
