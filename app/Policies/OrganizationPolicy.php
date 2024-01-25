<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;

class OrganizationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        /* Anyone can see the list of organizations. */
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Organization $organization): bool
    {
        /* Anyone can see the details of an organization. */
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        /* No user type/role can create a new organization. */
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Organization $organization): bool
    {
        /*
         * An organization can be updated only by BB Admins, BB Managers
         *  and NGO Admins that belong to the organization.
         */
        return $user->isSuperUser() ||
            $user->isOrganizationAdmin($organization) || $user->isOrganizationManager($organization);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Organization $organization): bool
    {
        /*
         * An organization can be deleted only by BB Admins, BB Managers
         *  and NGO Admins that belong to the organization.
         */
        return $user->isSuperUser() || $user->isOrganizationAdmin($organization);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Organization $organization): bool
    {
        /*
         * An organization can be restored only by BB Admins and BB Managers.
         */
        return $user->isSuperUser();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Organization $organization): bool
    {
        return false;
    }
}
