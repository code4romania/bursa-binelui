<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Enums\UserRole;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;

trait HasRole
{
    public function initializeHasRole(): void
    {
        $this->casts['role'] = UserRole::class;
    }

    private function hasRole(UserRole $role): bool
    {
        return $this->role === $role;
    }

    public function isSuperUser(): bool
    {
        return $this->isSuperAdmin() || $this->isSuperManager();
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(UserRole::SUPERADMIN);
    }

    public function isSuperManager(): bool
    {
        return $this->hasRole(UserRole::SUPERMANAGER);
    }

    public function isOrganizationAdmin(?Organization $organization = null): bool
    {
        return $this->hasRole(UserRole::ADMIN) && $this->belongsToOrganization($organization);
    }

    public function isOrganizationManager(?Organization $organization = null): bool
    {
        return $this->hasRole(UserRole::USER) && $this->belongsToOrganization($organization);
    }

    // ========================================== //
    public function scopeOnlySuperUsers(Builder $query): Builder
    {
        return $query->whereIn('role', [UserRole::SUPERADMIN, UserRole::SUPERMANAGER]);
    }

    public function scopeOnlySuperAdmins(Builder $query): Builder
    {
        return $query->where('role', UserRole::SUPERADMIN);
    }

    public function scopeOnlySuperManagers(Builder $query): Builder
    {
        return $query->where('role', UserRole::SUPERMANAGER);
    }

    public function scopeWithoutSuperUsers(Builder $query): Builder
    {
        return $query->whereNotIn('role', [UserRole::SUPERADMIN, UserRole::SUPERMANAGER]);
    }

    // ========================================== //

    public function scopeOnlyOrganizationAdmins(Builder $query, ?Organization $organization = null): Builder
    {
        return $query->where('role', UserRole::ADMIN)
            ->whereBelongsToOrganization($organization);
    }

    // ========================================== //

    public function isDonor(): bool
    {
        return $this->role === UserRole::donor;
    }
}
