<?php

declare(strict_types=1);

namespace App\Console;

use App\Jobs\ProcessAuthorizedTransactionsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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

        $schedule->command('app:notification-end-project-period', ['--days' => 10])
            ->dailyAt('09:00')
            ->onOneServer()
            ->sentryMonitor('notification-end-project-period');

        $schedule->command('app:notification-end-project-period', ['--days' => 2])
            ->dailyAt('10:00')
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
