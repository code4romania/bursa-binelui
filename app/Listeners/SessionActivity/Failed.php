<?php

declare(strict_types=1);

namespace App\Listeners\SessionActivity;

use Illuminate\Auth\Events\Failed as FailedEvent;
use Illuminate\Support\Facades\Log;

class Failed
{
    public function handle(FailedEvent $event): void
    {
        Log::info('User login attempt failed', ['email' => $event->credentials['email']]);
    }
}
