<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use App\Enums\OrganizationStatus;
use App\Models\ActivityDomain;
use App\Models\Organization;
use App\Services\Sanitize;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Throwable;

class ImportOrganizationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:organizations
        {--chunk=20 : The number of records to process at a time}
        {--skip-files : Skip importing files}
        {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import organizations from the old database.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return static::FAILURE;
        }

        $this->importOrganizations();
        $this->importActivityDomains();

        return static::SUCCESS;
    }

    protected function importOrganizations(): void
    {
        $query = $this->db
            ->table('dbo.ONGs')
            ->orderBy('dbo.ONGs.Id');

        $this->createProgressBar(
            $this->option('skip-files')
                ? 'Importing organizations [skip-files]...'
                : 'Importing organizations...',
            $query->count()
        );

        $query->chunk((int) $this->option('chunk'), function (Collection $items) {
            $items
                ->reject(fn (object $row) => $this->getRejectedOrganizations()->contains($row->Id))
                ->each(function (object $row) {
                    try {
                        $created_at = Carbon::parse($row->CreationDate);

                        $organization = Organization::forceCreate([
                            'id' => (int) $row->Id,
                            'cif' => Sanitize::text($row->CIF),
                            'name' => Sanitize::text($row->Name),
                            'slug' => Sanitize::text($row->DynamicUrl),
                            'description' => Sanitize::text($row->Description),
                            'address' => Sanitize::text($row->Address, 255),
                            'contact_phone' => Sanitize::text($row->PhoneNb),
                            'contact_email' => Sanitize::email($row->Email),
                            'contact_person' => Sanitize::text($row->ContactPerson),
                            'website' => Sanitize::url($row->WebSite),
                            'facebook' => Sanitize::url($row->FacebookPageLink),
                            'accepts_volunteers' => Sanitize::truthy($row->HasVolunteering),
                            'why_volunteer' => Sanitize::text($row->WhyVolunteer),
                            'status' => match ($row->ONGStatusId) {
                                1 => OrganizationStatus::pending,
                                2 => OrganizationStatus::approved,
                                3 => OrganizationStatus::rejected,
                            },
                            'status_updated_at' => $created_at,
                            'created_at' => $created_at,
                            'updated_at' => $created_at,
                            'eu_platesc_merchant_id' => Sanitize::text($row->MerchantId),
                            'eu_platesc_private_key' => Sanitize::text($row->MerchantKey),
                        ]);

                        if (! $this->option('skip-files')) {
                            // Add logo
                            $this->addFilesToCollection($organization, $row->LogoImageId, 'logo');

                            // Add statute
                            $this->addFilesToCollection($organization, $row->OrganizationalStatusId, 'statute');

                            // Add annual report
                            $this->addFilesToCollection($organization, $row->AnualReportFileId);
                        }
                    } catch (Throwable $th) {
                        $this->logError('Error importing organization #' . $row->Id, [$th->getMessage()]);
                    }

                    $this->progressBar->advance();
                });
        });

        $this->finishProgressBar(
            $this->option('skip-files')
                ? 'Imported organizations [skip-files]'
                : 'Imported organizations',
        );
    }

    protected function importActivityDomains(): void
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
            try {
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
            } catch (Throwable $th) {
                $this->logError('Error importing activity domain #' . $row->Id, [$th->getMessage()]);
            }

            $this->progressBar->advance();
        });

        $this->finishProgressBar('Imported activity domains');
    }
}
