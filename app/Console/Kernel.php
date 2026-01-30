<?php

declare(strict_types=1);

namespace App\Console;

use App\Jobs\ProcessAuthorizedTransactionsJob;
use App\Models\Setting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $daysBeforeProjectExpiration = (int) (Setting::value('project_expiration_notification_days_before') ?? 7);
        $daysBeforeProjectExpirationReminder = (int) (Setting::value('project_expiration_notification_days_before_reminder') ?? 2);

        $schedule->command('model:prune')
            ->daily()
            ->name('model-prune')
            ->onOneServer()
            ->sentryMonitor('model-prune');

        $schedule->job(ProcessAuthorizedTransactionsJob::class)
            ->everyFourHours()
            ->name('transactions-process-authorized')
            ->onOneServer()
            ->sentryMonitor('process-authorized-transactions-job');

        $schedule->command('app:notification-end-project-period', ['--days' => $daysBeforeProjectExpiration])
            ->dailyAt('09:00')
            ->name('notification-end-project-period')
            ->onOneServer()
            ->sentryMonitor('notification-end-project-period');

        $schedule->command('app:notification-end-project-period', ['--days' => $daysBeforeProjectExpirationReminder])
            ->dailyAt('10:00')
            ->name('notification-end-project-period-reminder')
            ->onOneServer()
            ->sentryMonitor('notification-end-project-period');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
