<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use Illuminate\Support\Collection;
use Throwable;

class ImportDonationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:donations
        {--chunk=100 : The number of records to process at a time}
        {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import donations from the old database.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return static::FAILURE;
        }

        $query = $this->db
            ->table('dbo.Donations')
            ->orderBy('dbo.Donations.Id');

        $this->createProgressBar('Importing donations...', $query->count());

        $query->chunk((int) $this->option('chunk'), function (Collection $items) {
            $items
                ->reject(fn (object $row) => $this->getRejectedOrganizations()->contains($row->ONGId))
                ->each(function (object $row) {
                    try {
                        // TODO: import donations
                    } catch (Throwable $th) {
                        $this->logError('Error importing donation #' . $row->Id, [$th->getMessage()]);
                    }

                    $this->progressBar->advance();
                });
        });

        $this->finishProgressBar('Imported donations');

        return static::SUCCESS;
    }
}
