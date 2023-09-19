<?php

declare(strict_types=1);

namespace App\Listeners\Ticket;

use App\Events\Ticket\TicketCreated;
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
                ->onlySuperUsers()
                ->get(),
            new Admin\TicketCreatedNotification($event->ticket)
        );

        Notification::send(
            User::query()
                ->whereBelongsToOrganization($event->ticket->organization)
                ->get(),
            new Ngo\TicketCreatedNotification($event->ticket)
        );
    }
}
