<?php

declare(strict_types=1);

namespace App\Notifications\Ngo;

use App\Models\TicketMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketReceivedReplyNotification extends Notification
{
    use Queueable;

    public TicketMessage $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(TicketMessage $message)
    {
        $this->message = $message;
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
            ->subject(__('ticket.mail.replied.subject', [
                'id' => $this->message->ticket->id,
            ]))
            ->line(__('ticket.mail.replied.subject', [
                'id' => $this->message->ticket->id,
            ]))
            ->action(
                __('ticket.action.view'),
                route('dashboard.tickets.view', [
                    $this->message->ticket,
                    "#reply-{$this->message->id}",
                ])
            );
    }
}
