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
            ->name('model-prune')
            ->onOneServer()
            ->sentryMonitor('model-prune');

        $schedule->job(ProcessAuthorizedTransactionsJob::class)
            ->everyFourHours()
            ->name('transactions-process-authorized')
            ->onOneServer()
            ->sentryMonitor('process-authorized-transactions-job');

        $schedule->command('app:notification-end-project-period')
            ->dailyAt('09:00')
            ->name('notification-end-project-period')
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
