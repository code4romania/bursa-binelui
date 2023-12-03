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
    protected $signature = 'app:import
        {--skip-files : Skip importing files}
        {--force : Force the operation to run when in production}';

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
        if (! $this->confirmToProceed()) {
            return static::FAILURE;
        }

        $this->call(ImportPrepareCommand::class, [
            '--force' => $this->option('force'),
        ]);

        $this->call(ImportOrganizationsCommand::class, [
            '--skip-files' => $this->option('skip-files'),
            '--force' => $this->option('force'),
        ]);

        $this->call(ImportUsersCommand::class, [
            '--force' => $this->option('force'),
        ]);

        $this->call(ImportProjectsCommand::class, [
            '--skip-files' => $this->option('skip-files'),
            '--force' => $this->option('force'),
        ]);

//        $this->call(ImportDonationsCommand::class, [
//            '--force' => $this->option('force'),
//        ]);

        $this->call(ImportArticlesCommand::class, [
            '--skip-files' => $this->option('skip-files'),
            '--force' => $this->option('force'),
        ]);

        return static::SUCCESS;
    }
}
