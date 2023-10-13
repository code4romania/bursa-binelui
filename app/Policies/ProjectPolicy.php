<?php

declare(strict_types=1);

namespace App\Policies;

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
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->belongsToOrganization($project->organization);
    }

    public function editAsNgo(User $user, Project $project): bool
    {
        return $user->belongsToOrganization($project->organization);
    }
}
