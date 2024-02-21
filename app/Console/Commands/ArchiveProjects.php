<?php

namespace App\Console\Commands;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Illuminate\Console\Command;

class ArchiveProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:arhive-projects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Project::query()
            ->where('end', '<', date("Y-m-d"))
            ->where('status', '!=', ProjectStatus::archived)
            ->update(['status' => ProjectStatus::archived]);
    }
}
