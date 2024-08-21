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
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
