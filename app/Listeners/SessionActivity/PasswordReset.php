<?php

declare(strict_types=1);

namespace App\Listeners\SessionActivity;

use Illuminate\Auth\Events\PasswordReset as PasswordResetEvent;
use Illuminate\Support\Facades\Log;

class PasswordReset
{
    public function handle(PasswordResetEvent $event): void
    {
        Log::info('User password reset', $event->user->only('id', 'email'));
    }
}
