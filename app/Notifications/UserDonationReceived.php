<?php

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserDonationReceived extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Donation $donation)
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
            ->subject('Ai făcut o donație pe platforma Bursa Binelui')
            ->line('Donația ta a fost înregistrată pe platforma Bursa Binelui, îți mulțumim că ai ajutat activitatea civililor. Poți să mai verifici și celelalte proiecte și să atragi atenția și altora asupra aceastei oportunitate. Ajută-ne să facem căt mai multe fapte bune, să facem o diferență!')
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
