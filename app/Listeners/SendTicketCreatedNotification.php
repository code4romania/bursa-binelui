<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Models\User;
use App\Notifications\Admin;
use App\Notifications\Ngo;
use Illuminate\Support\Facades\Notification;

class SendTicketCreatedNotification
{
    /**
     * Handle the event.
     */
    public function handle(TicketCreated $event): void
    {
        Notification::send(
            User::query()
                ->onlyBBAdmins()
                ->get(),
            new Admin\TicketCreatedNotification($event->ticket)
        );

        Notification::send(
            User::query()
                ->onlyNGOAdmins($event->ticket->organization)
                ->get(),
            new Ngo\TicketCreatedNotification($event->ticket)
        );
    }
}
