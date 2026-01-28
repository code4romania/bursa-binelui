<?php

declare(strict_types=1);

namespace App\Console;

use App\Jobs\ProcessAuthorizedTransactionsJob;
use App\Models\Setting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('model:prune')
            ->daily()
            ->onOneServer()
            ->sentryMonitor('model-prune');

        $schedule->job(ProcessAuthorizedTransactionsJob::class)
            ->everyFourHours()
            ->onOneServer()
            ->sentryMonitor('process-authorized-transactions-job');

        $schedule->call(function () {
            $days = (int) (Setting::value('project_expiration_notification_days_before') ?? 10);
            Artisan::call('app:notification-end-project-period', ['--days' => $days]);
        })
            ->dailyAt('09:00')
            ->onOneServer()
            ->sentryMonitor('notification-end-project-period');

        $schedule->call(function () {
            $days = (int) (Setting::value('project_expiration_notification_days_before_reminder') ?? 2);
            Artisan::call('app:notification-end-project-period', ['--days' => $days]);
        })
            ->dailyAt('10:00')
            ->onOneServer()
            ->sentryMonitor('notification-end-project-period-reminder');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
