<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\UserRole;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait HasRole
{
    public function initializeHasRole()
    {
        $this->casts['role'] = UserRole::class;
    }

    public function hasRole(string $role): bool
    {
        return $this->role === UserRole::tryFrom($role);
    }

    public function isDonor(): bool
    {
        return $this->role === UserRole::donor;
    }

    public function isNgoAdmin(): bool
    {
        return $this->role === UserRole::ngo_admin;
    }

    public function isBbManager(): bool
    {
        return $this->role === UserRole::bb_manager;
    }

    public function isBbAdmin(): bool
    {
        return $this->role === UserRole::bb_admin;
    }

    public function scopeRole(Builder $query, array|string|Collection|UserRole $roles): Builder
    {
        return $query->whereIn('role', collect($roles));
    }

    public function scopeOnlyBBAdmins(Builder $query): Builder
    {
        return $query->role(UserRole::bb_admin);
    }

    public function scopeOnlyNGOAdmins(Builder $query, ?Organization $organization = null): Builder
    {
        return $query->role(UserRole::ngo_admin)
            ->when($organization !== null, function (Builder $query) use ($organization) {
                return $query->where('organization_id', $organization->id);
            });
    }
}
