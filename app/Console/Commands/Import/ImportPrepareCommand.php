<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use App\Models\ActivityDomain;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Commands\CleanCommand;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
     * List of models to truncate.
     *
     * @var array
     */
    private array $models = [
        ActivityDomain::class,
        Media::class,
        Organization::class,
        User::class,
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->createProgressBar('Removing old data...', \count($this->models));

        foreach ($this->progressBar->iterate($this->models) as $model) {
            if ($model === Media::class) {
                Artisan::call(CleanCommand::class);
            }

            Schema::withoutForeignKeyConstraints(fn () => $model::truncate());
        }

        $this->progressBar->finish();

        return static::SUCCESS;
    }
}
