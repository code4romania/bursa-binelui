<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserWasApprovedForVolunteering extends Notification implements ShouldQueue
{
    use Queueable;

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
            ->greeting('Salut,')
            ->subject('Cererea ta de voluntariat a fost acceptată')
            ->line('Organizația a acceptat cererea ta de voluntariat. Vei fi contactat de organizație pentru a discuta între voi detaliile. ')
            ->line('Vă mulțumim pentru implicare!')
            ->salutation('Echipa Bursa Binelui');
    }
}
