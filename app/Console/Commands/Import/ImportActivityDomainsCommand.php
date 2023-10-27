<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use App\Models\ActivityDomain;
use App\Services\Sanitize;
use Illuminate\Support\Collection;

class ImportActivityDomainsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:activity-domains {--chunk=100 : The number of records to process at a time}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import activity domains from the old database.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $query = $this->db
            ->table('lkp.ActivityDomains')
            ->orderBy('lkp.ActivityDomains.Id');

        $this->createProgressBar('Importing activity domains...', $query->count());

        $chunk = (int) $this->option('chunk');

        $query->chunk($chunk, function (Collection $items) {
            $values = $items
                ->map(fn (object $row) => [
                    'id' => (int) $row->Id,
                    'name' => Sanitize::text($row->Name),
                    'slug' => Sanitize::slug($row->Name),
                ]);

            ActivityDomain::upsert($values->all(), 'id');

            $this->progressBar->advance($values->count());
        });

        $this->progressBar->finish();

        return static::SUCCESS;
    }
}
