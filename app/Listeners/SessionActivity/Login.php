<?php

declare(strict_types=1);

namespace App\Listeners\SessionActivity;

use Illuminate\Auth\Events\Login as LoginEvent;
use Illuminate\Support\Facades\Log;

class Login
{
    public function handle(LoginEvent $event): void
    {
        Log::info('User logged in', $event->user->only('id', 'email'));
    }
}
