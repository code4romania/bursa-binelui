<?php

declare(strict_types=1);

namespace App\Notifications\Ngo;

use App\Models\Project;
use App\Models\RegionalProject;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectCreated extends Notification
{
    use Queueable;

    private Project|RegionalProject $project;

    /**
     * Create a new notification instance.
     */
    public function __construct(Project|RegionalProject $project)
    {
        $this->project = $project;
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
            ->line(__('mail.ngo.project_created.line_1'))
            ->action(__('mail.ngo.action_button'), url('/'));
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
