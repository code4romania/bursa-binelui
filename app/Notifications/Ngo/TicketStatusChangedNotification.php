<?php

declare(strict_types=1);

namespace App\Notifications\Ngo;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketStatusChangedNotification extends Notification
{
    use Queueable;

    public Ticket $ticket;

    public bool $isOpen;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket, bool $isOpen)
    {
        $this->ticket = $ticket;
        $this->isOpen = $isOpen;
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
        return $this->isOpen
            ? $this->buildReopenedMail($notifiable)
            : $this->buildClosedMail($notifiable);
    }

    protected function buildClosedMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('ticket.mail.closed.subject', [
                'id' => $this->ticket->id,
            ]))
            ->line(__('ticket.mail.closed.subject', [
                'id' => $this->ticket->id,
            ]))
            ->action(
                __('ticket.action.view'),
                route('dashboard.tickets.view', $this->ticket)
            );
    }

    protected function buildReopenedMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('ticket.mail.reopened.subject', [
                'id' => $this->ticket->id,
            ]))
            ->line(__('ticket.mail.reopened.subject', [
                'id' => $this->ticket->id,
            ]))
            ->action(
                __('ticket.action.view'),
                route('dashboard.tickets.view', $this->ticket)
            );
    }
}
