<?php

declare(strict_types=1);

namespace App\Listeners\Ticket;

use App\Events\Ticket\TicketUpdated;
use App\Models\User;
use App\Notifications\Admin;
use App\Notifications\Ngo;
use Illuminate\Support\Facades\Notification;

class SendTicketStatusChangedNotification
{
    /**
     * Handle the event.
     */
    public function handle(TicketUpdated $event): void
    {
        if ($event->ticket->getOriginal('closed_at') === $event->ticket->closed_at) {
            return;
        }

        $ticketIsOpen = $event->ticket->closed_at === null;

        Notification::send(
            User::query()
                ->onlySuperUsers()
                ->get(),
            new Admin\TicketStatusChangedNotification($event->ticket, $ticketIsOpen)
        );

        Notification::send(
            User::query()
                ->whereBelongsToOrganization($event->ticket->organization)
                ->get(),
            new Ngo\TicketStatusChangedNotification($event->ticket, $ticketIsOpen)
        );
    }
}
