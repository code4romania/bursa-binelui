<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\Setting;
use App\Notifications\Ngo\ProjectEndingNotification;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;

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
        $this->projectsEndingNotification('project_expiration_notification_days_before', 7);
        $this->projectsEndingNotification('project_expiration_notification_days_before_reminder', 2);
    }

    private function projectsEndingNotification(string $setting, int $fallbackDays)
    {
        $days = (int) (Setting::value($setting) ?? $fallbackDays);

        $this->info('Notifying projects ending in ' . $days . ' days');

        $projects = Project::withoutEagerLoads()
            ->with([
                'organization.users' => function (Builder $query) {
                    $query->whereNotNull('email_verified_at');
                },
            ])
            ->whereIsApproved()
            ->whereDate('end', now()->addDays($days))
            ->get();

        $projects->each(function (Project $project) use ($days) {
            Notification::send($project->organization->users, new ProjectEndingNotification($project, $days));
        });
    }
}
