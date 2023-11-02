<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

/**
 * @see docs/migrate.md
 */
class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import {--skip-files : Skip importing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all the importers in order.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->call(ImportPrepareCommand::class);

        $this->call(ImportOrganizationsCommand::class, [
            '--skip-files' => $this->option('skip-files'),
        ]);
        $this->call(ImportProjectsCommand::class, [
            '--skip-files' => $this->option('skip-files'),
        ]);

        $this->call(ImportUsersCommand::class);

        $this->call(ImportArticlesCommand::class, [
            '--skip-files' => $this->option('skip-files'),
        ]);

        return static::SUCCESS;
    }
}
