<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use App\Enums\OrganizationStatus;
use App\Models\Organization;
use App\Services\Sanitize;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ImportOrganizationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:organizations {--chunk=20 : The number of records to process at a time}';

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
        $query = $this->db
            ->table('dbo.ONGs')
            ->orderBy('dbo.ONGs.Id');

        $this->createProgressBar('Importing organizations...', $query->count());

        $query->chunk((int) $this->option('chunk'), function (Collection $items) {
            $items
                ->reject(fn (object $row) => $this->getRejectedOrganizations()->contains($row->Id))
                ->each(function (object $row) {
                    $created_at = Carbon::parse($row->CreationDate);

                    $organization = Organization::forceCreate([
                        'id' => (int) $row->Id,
                        'cif' => Sanitize::text($row->CIF),
                        'name' => Sanitize::text($row->Name),
                        'slug' => Sanitize::text($row->DynamicUrl),
                        'description' => $row->Description,
                        'address' => Sanitize::text($row->Address, 255),
                        'contact_phone' => Sanitize::text($row->PhoneNb),
                        'contact_email' => Sanitize::email($row->Email),
                        'contact_person' => Sanitize::text($row->ContactPerson),
                        'website' => Sanitize::url($row->WebSite),
                        'facebook' => Sanitize::url($row->FacebookPageLink),
                        'accepts_volunteers' => Sanitize::truthy($row->HasVolunteering),
                        'why_volunteer' => $row->WhyVolunteer,
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

                    // Add logo
                    $this->addFileToCollection($organization, $row->LogoImageId, 'logo');

                    // Add statute
                    $this->addFileToCollection($organization, $row->OrganizationalStatusId, 'statute');

                    // Add annual report
                    $this->addFileToCollection($organization, $row->AnualReportFileId);

                    $this->progressBar->advance();
                });
        });

        $this->progressBar->finish();

        return static::SUCCESS;
    }
}
