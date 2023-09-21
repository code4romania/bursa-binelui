<?php

declare(strict_types=1);

namespace App\Listeners\User;

use App\Events\User\UserDeleting;
use Illuminate\Support\Facades\Log;

class DeleteOrganization
{
    /**
     * Handle the event.
     */
    public function handle(UserDeleting $event): void
    {
        if (
            ! $event->user->isOrganizationAdmin() ||
            $event->user->organization->users()->count() > 1
        ) {
            return;
        }

        Log::info('DeleteOrganization', [
            'user' => $event->user->id,
            'organization' => $event->user->organization->id,
        ]);

        $event->user->organization->delete();
    }
}
