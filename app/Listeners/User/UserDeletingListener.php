<?php

namespace App\Listeners\User;

use App\Events\User\UserDeleting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UserDeletingListener
{
    /**
     * Handle the event.
     */
    public function handle(UserDeleting $event): void
    {
        $user = $event->user->loadMissing('organization');
        Log::info('UserDeletingListener', [
            'user' => $user->id,
            'organization' => $event->user->organization->id,
        ]);
        $user->organization->delete();
    }
}
