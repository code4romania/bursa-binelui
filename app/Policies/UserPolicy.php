<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, User $model): bool
    {
        return $user->isSuperUser() || $user->belongstoOrganization($model->organization);
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isOrganizationAdmin();
    }

    public function update(User $user, User $model): bool
    {
        return $user->isSuperAdmin() || $user->isOrganizationAdmin($model->organization);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->isSuperAdmin() || $user->isOrganizationAdmin($model->organization);
    }

    public function restore(User $user, User $model): bool
    {
        return $user->isSuperAdmin() || $user->isOrganizationAdmin($model->organization);
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->isSuperAdmin() || $user->isOrganizationAdmin($model->organization);
    }
}
