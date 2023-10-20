<?php

declare(strict_types=1);

namespace App\Notifications\Ngo;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRemovedFromOrganizationNotification extends Notification
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
            ->subject(__('user.mail.remove_from_organization.subject', ['app' => config('app.name')]))
            ->greeting(__('user.mail.remove_from_organization.greeting', [
                'name' => $notifiable->name,
            ]))
            ->line(__('user.mail.remove_from_organization.intro', [
                'app' => config('app.name'),
            ]));
    }
}
