<?php

declare(strict_types=1);

namespace App\Notifications\Ngo;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationReceived extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
            ->greeting('Salut,')
            ->subject('Ai primit o donație pentru proiectul tău listat pe Bursa Binelui')
            ->line('Proiectul organizației tale listat pe Bursa Binelui a fost inițializată o donație. Poți să vizualizezi detaliile tranzacțiilor intrând în contul tău pe platforma Bursa Binelui!')
            ->line('Îţi mulțumim,')
            ->salutation('Echipa Bursa Binelui');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
