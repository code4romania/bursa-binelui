<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Concerns\HasRole;
use App\Concerns\MustSetInitialPassword;
use App\Events\User\UserDeleting;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use BelongsToOrganization;
    use HasFactory;
    use Notifiable;
    use HasRole;
    use MustSetInitialPassword;
    use Prunable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'referrer',
        'created_by',
        'organization_id',
        'newsletter',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'deleting' => UserDeleting::class,
    ];

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class)
            ->using(BadgeUser::class)
            ->orderByPivot('allocated_at', 'desc');
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function canAccessFilament(): bool
    {
        return $this->isSuperUser();
    }

    public function getFilamentName(): string
    {
        return "{$this->name}";
    }

    public function volunteer(): HasOne
    {
        return $this->hasOne(Volunteer::class);
    }

    public function volunteerRequest(): HasManyThrough
    {
        return $this->hasManyThrough(VolunteerRequest::class, Volunteer::class);
    }

    public function prunable(): Builder
    {
        return static::query()
            ->with('organization:id,name')
            ->where('created_at', '<=', now()->subHours(48))
            ->withoutSuperUsers()
            ->whereNull('email_verified_at')
            ->whereNull('password_set_at');
    }

    public function scopeWhereHasVerifiedEmail(Builder $query): Builder
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeWhereDoesntHaveVerifiedEmail(Builder $query): Builder
    {
        return $query->whereNull('email_verified_at');
    }
}
