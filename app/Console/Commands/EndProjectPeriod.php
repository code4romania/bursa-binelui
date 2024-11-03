<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Project;
use App\Notifications\Ngo\ProjectEndingNotification;
use Illuminate\Console\Command;

class EndProjectPeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification-end-project-period {--days=7}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users that a project is ending in a number of days';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Ending project period...');
        $daysBeforeEnding = (int) $this->option('days') ?? 7;
        $this->info("Ending period {$daysBeforeEnding}...");
        $projects = Project::withoutEagerLoads()->with(['organization'])
            ->whereIsApproved()
            ->whereDate('end', now()->addDays($daysBeforeEnding))
            ->get();
        $projects->each(function (Project $project) use ($daysBeforeEnding) {

           $users =  $project->organization->load('users')->users->filter(function ($user) {
                return $user->hasVerifiedEmail();
            });
           \Notification::send($users, new ProjectEndingNotification($project, $daysBeforeEnding));

        });
    }
}
