<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\MustSetInitialPassword;
use App\Enums\UserRole;
use App\Events\User\UserDeleting;
use App\Traits\HasRole;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasApiTokens;
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
        'organization_id',
        'source_of_information',
        'created_by',
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

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function currentOrganization(): Organization
    {
        return $this->organization()->first();
    }

    public function canAccessFilament(): bool
    {
        return $this->isBBAdmin() || $this->isBBManager();
    }

    public function getFilamentName(): string
    {
        return "{$this->name}";
    }

    public function prunable(): Builder
    {
        return static::query()
            ->with('organization:id,name')
            ->where('created_at', '<=', now()->subHours(48))
            ->whereNotIn('role', [UserRole::bb_admin, UserRole::bb_manager])
            ->whereNull('email_verified_at')
            ->whereNull('password_set_at');
    }
}
