<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use Illuminate\Database\Console\Migrations\FreshCommand;
use Spatie\MediaLibrary\MediaCollections\Commands\CleanCommand;

class ImportPrepareCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:prepare';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove old data and prepare for import.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->createProgressBar('Removing old data...', 2);

        $this->callSilent(FreshCommand::class);
        $this->progressBar->advance();

        $this->callSilent(CleanCommand::class);

        $this->finishProgressBar('Removed old data');

        return static::SUCCESS;
    }
}
