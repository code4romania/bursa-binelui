<?php

declare(strict_types=1);

namespace App\Notifications\Ngo;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class TicketCreatedNotification extends Notification
{
    use Queueable;

    public Ticket $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting(__('mail.greeting'))
            ->salutation(
                new HtmlString(__('mail.salutation') . '<br/>' . __('mail.team'))
            )
            ->subject(__('ticket.mail.created.subject', [
                'id' => $this->ticket->id,
            ]))
            ->line(__('ticket.mail.created.line', [
                'id' => $this->ticket->id,
            ]))
            ->action(
                __('ticket.action.view'),
                route('dashboard.tickets.view', $this->ticket)
            );
    }
}
