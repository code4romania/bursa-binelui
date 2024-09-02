<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\GalaProject;
use App\Models\User;

class GalaProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, GalaProject $project): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->belongsToOrganization($project->organization);
    }

    public function update(User $user, GalaProject $project): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if (! $project->isDraft()) {
            return  false;
        }

        return $user->belongsToOrganization($project->organization);
    }
}
