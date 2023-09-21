<?php

declare(strict_types=1);

namespace App\Listeners\Ticket;

use App\Events\Ticket\TicketReplyReceived;
use App\Models\User;
use App\Notifications\Admin;
use App\Notifications\Ngo;
use Illuminate\Support\Facades\Notification;

class SendTicketReplyReceivedNotification
{
    /**
     * Handle the event.
     */
    public function handle(TicketReplyReceived $event): void
    {
        Notification::send(
            User::query()
                ->onlySuperUsers()
                ->get(),
            new Admin\TicketReceivedReplyNotification($event->message)
        );

        Notification::send(
            User::query()
                ->whereBelongsToOrganization($event->message->ticket->organization)
                ->get(),
            new Ngo\TicketReceivedReplyNotification($event->message)
        );
    }
}
