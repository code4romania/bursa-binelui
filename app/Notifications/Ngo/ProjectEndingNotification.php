<?php

declare(strict_types=1);

namespace App\Notifications\Ngo;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectEndingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Project $project, private int $daysBeforeEnding)
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
            ->subject("Perioada de donații pentru proiectul tău, {$this->project->name}, se apropie de sfârșit")
            ->greeting('Salut,')
            ->line("Perioada de donații pentru proiectul organizației tale, {$this->project->name}, listat pe Bursa Binelui se apropie de sfârșit. Dacă vrei să prelungești perioada de donații, mai ai {$this->daysBeforeEnding} zile calendaristice să faci acest lucru.
")
            ->line('IMPORTANT! Dacă nu modifici termenul limită al perioadei de donații, proiectul tău va fi închis automat de sistem. Poți să redeschizi proiectul și ulterior, accesând Proiectele tale din contul tău de pe platforma Bursa Binelui.')
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
