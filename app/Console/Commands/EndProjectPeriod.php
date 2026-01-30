<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\Setting;
use App\Notifications\Ngo\ProjectEndingNotification;
use Illuminate\Console\Command;

class EndProjectPeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification-end-project-period';

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
        $daysBeforeProjectExpiration = (int) (Setting::value('project_expiration_notification_days_before') ?? 7);
        $daysBeforeProjectExpirationReminder = (int) (Setting::value('project_expiration_notification_days_before_reminder') ?? 2);
        $this->info('Notifying projects ending in ' . $daysBeforeProjectExpiration);
        $this->projectsEndingNotification($daysBeforeProjectExpiration);
        $this->info('Notifying projects ending in ' . $daysBeforeProjectExpirationReminder . ' (reminder)');
        $this->projectsEndingNotification($daysBeforeProjectExpirationReminder);
    }

    private function projectsEndingNotification(int $days)
    {
        $projects = Project::withoutEagerLoads()
            ->with(['organization.users'])
            ->whereIsApproved()
            ->whereDate('end', now()->addDays($days))
            ->get();
        $projects->each(function (Project $project) use ($days) {
            $users = $project->organization->users->filter(function ($user) {
                return $user->hasVerifiedEmail();
            });
            \Notification::send($users, new ProjectEndingNotification($project, $days));
        });
    }
}
