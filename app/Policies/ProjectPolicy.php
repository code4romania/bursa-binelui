<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Organization;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }
    public function view(User $user, Project $project): bool
    {
        if ($user->organization_id !== $project->organization_id) {
            return false;
        }
        /* Anyone can see the details of an organization. */
        return true;
    }

    public function editAsNgo(User $user, Project $project): bool
    {
        if ($user->organization_id !== $project->organization_id && $user->role !== UserRole::ngo_admin) {
            return false;
        }
        return true;
    }
}
