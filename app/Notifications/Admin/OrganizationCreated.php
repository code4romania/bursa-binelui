<?php

declare(strict_types=1);

namespace App\Notifications\Admin;

use App\Filament\Resources\OrganizationResource;
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
            ->subject(__('mail.admin.organization_created.subject', ['name' => $this->organization->name]))
            ->greeting(__('mail.greeting'))
            ->salutation(
                new HtmlString(__('mail.salutation') . '<br/>' . __('mail.team'))
            )
            ->line(__('mail.admin.organization_created.line_1', ['name' => $this->organization->name]))
            ->action(__('mail.admin.organization_created.action'), OrganizationResource::getUrl('view', ['record' => $this->organization]));
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
