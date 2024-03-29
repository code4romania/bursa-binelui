<?php

declare(strict_types=1);

namespace App\Notifications\Ngo;

use App\Models\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OrganizationCreated extends Notification
{
    use Queueable;

    private Organization $organization;

    /**
     * Create a new notification instance.
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
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
            ->subject(__('mail.ngo.organization_created.subject'))
            ->greeting(__('mail.greeting'))
            ->salutation(
                new HtmlString(__('mail.salutation') . '<br/>' . __('mail.team'))
            )
            ->line(__('mail.ngo.organization_created.line_1'))
            ->line(__('mail.ngo.organization_created.line_2'))
            ->line(__('mail.ngo.organization_created.line_3'));
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
