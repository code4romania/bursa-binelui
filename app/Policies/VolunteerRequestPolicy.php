<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\VolunteerRequest;

class VolunteerRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, VolunteerRequest $volunteerRequest): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, VolunteerRequest $volunteerRequest): bool
    {
        if ($user->isSuperUser()) {
            return true;
        }

        if ($volunteerRequest->targetingOrganization()) {
            return $user->belongsToOrganization($volunteerRequest->model);
        }

        return $user->belongsToOrganization($volunteerRequest->model->organization);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, VolunteerRequest $volunteerRequest): bool
    {
        return $this->update($user, $volunteerRequest);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, VolunteerRequest $volunteerRequest): bool
    {
        if ($user->isSuperUser()) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, VolunteerRequest $volunteerRequest): bool
    {
        if ($user->isSuperUser()) {
            return true;
        }
    }
}
