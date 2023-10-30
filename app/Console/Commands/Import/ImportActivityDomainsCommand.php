<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use App\Models\ActivityDomain;
use App\Models\Organization;
use App\Services\Sanitize;

class ImportActivityDomainsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:activity-domains';

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
        $activityDomains = $this->db
            ->table('lkp.ActivityDomains')
            ->addSelect([
                'ONGsIds' => $this->db
                    ->table('dbo.ONGActivityDomains')
                    ->selectRaw("STRING_AGG(ONGId,',')")
                    ->whereColumn('dbo.ONGActivityDomains.ActivityDomainId', 'lkp.ActivityDomains.Id'),
            ])
            ->orderBy('lkp.ActivityDomains.Id')
            ->get();

        $this->createProgressBar('Importing activity domains...', $activityDomains->count());

        $organizations = Organization::query()
            ->orderBy('id')
            ->pluck('id');

        $activityDomains->each(function (object $row) use ($organizations) {
            $activityDomain = ActivityDomain::forceCreate([
                'id' => (int) $row->Id,
                'name' => Sanitize::text($row->Name),
                'slug' => Sanitize::slug($row->Name),
            ]);

            if ($row->ONGsIds) {
                $activityDomain->organizations()->sync(
                    $organizations->intersect(explode(',', $row->ONGsIds))
                );
            }

            $this->progressBar->advance();
        });

        $this->progressBar->finish();

        return static::SUCCESS;
    }
}
