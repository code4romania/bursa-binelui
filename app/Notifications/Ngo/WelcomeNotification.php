<?php

declare(strict_types=1);

namespace App\Notifications\Ngo;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class WelcomeNotification extends Notification
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
            ->subject(__('auth.welcome.subject'))
            ->greeting(__('auth.welcome.greeting', [
                'name' => $notifiable->full_name,
            ]))
            ->line(__('auth.welcome.intro', [
                'app' => config('app.name'),
            ]))
            ->action(__('auth.welcome.submit'), URL::signedRoute(
                'ngo.user.welcome',
                ['user' => $notifiable->id]
            ));
    }
}
