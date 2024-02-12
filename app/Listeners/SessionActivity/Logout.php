<?php

declare(strict_types=1);

namespace App\Listeners\SessionActivity;

use Illuminate\Auth\Events\Logout as LogoutEvent;
use Illuminate\Support\Facades\Log;

class Logout
{
    public function handle(LogoutEvent $event): void
    {
        Log::info('User logged out', $event->user->only('id', 'email'));
    }
}
