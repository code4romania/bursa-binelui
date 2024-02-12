<?php

declare(strict_types=1);

namespace App\Listeners\SessionActivity;

use Illuminate\Auth\Events\Registered as RegisteredEvent;
use Illuminate\Support\Facades\Log;

class Registered
{
    public function handle(RegisteredEvent $event): void
    {
        Log::info('User registered', $event->user->only('id', 'email'));
    }
}
