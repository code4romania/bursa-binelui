<?php

declare(strict_types=1);

namespace App\Notifications\Admin;

use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ExportExcelNotification extends Notification
{
    use Queueable;

    private string $filename;

    private User $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, string $fileName)
    {
        $this->user = $user;
        $this->filename = $fileName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('notification.export_finished.title'))
            ->line(__('notification.export_finished.body', ['filename' => $this->filename]))
            ->attach(Storage::disk('filament-excel')->path($this->filename));
//            ->action(__('notification.export_finished.action'), Storage::disk('filament-excel')->url($this->filename));
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

    public function toDatabase(): array
    {
        return FilamentNotification::make()
            ->title(__('notification.export_finished.title'))
            ->body(__('notification.export_finished.body', ['filename' => $this->filename]))
            ->success()
            ->seconds(5)
            ->icon('heroicon-o-inbox-in')
            ->actions([
                Action::make('export_excel')
                    ->label(__('filament-excel::notifications.download_ready.download'))
                    ->url($this->generateURL(), shouldOpenInNewTab: true)
                    ->button()
                    ->close(),
            ])
            ->getDatabaseMessage();
    }

    private function generateURL(): string
    {
        return URL::temporarySignedRoute(
            'filament-excel-download',
            now()->addHours(24),
            ['path' => $this->filename]
        );
    }
}
