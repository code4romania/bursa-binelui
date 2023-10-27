<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\OrganizationStatus;
use App\Enums\UserRole;
use App\Models\ActivityDomain;
use App\Models\Organization;
use App\Models\User;
use App\Services\Sanitize;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\Console\Helper\ProgressBar;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import';

    private readonly Connection $db;

    public function __construct()
    {
        $this->db = DB::connection('import');

        parent::__construct();
    }

    private function createProgressBar(string $status, int $max): ProgressBar
    {
        $progressBar = $this->output->createProgressBar($max);
        $progressBar->setFormat("\n<options=bold>%status:-30s% %current%/%max%</>\n[%bar%] %remaining%\n");
        $progressBar->setMessage($status, 'status');
        $progressBar->setBarCharacter('<fg=green>=</>');
        $progressBar->setEmptyBarCharacter('-');
        $progressBar->setProgressCharacter('<fg=green>></>');
        $progressBar->start();

        return $progressBar;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->truncate();

//        $this->importOrganizations();
        $this->importActivityDomains();
//        $this->importUsers();

        return static::SUCCESS;
    }

    protected function truncate(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            $models = [
                Media::class,
                User::class,
                Organization::class,
                ActivityDomain::class,
            ];

            $progressBar = $this->createProgressBar('Truncating tables...', \count($models));

            foreach ($progressBar->iterate($models) as $model) {
                $model::truncate();
            }

            $progressBar->finish();
        });
    }

    /**
     * Import organizations.
     *
     * - [Id] => id
     * - [Name] => name
     * - [LogoImageId] => ...
     * - [Description] => description
     * - [AnualReportFileId] => ?
     * - [Recommendations] => ?
     * - [CIF] => cif
     * - [Address] => address
     * - [PhoneNb] => contact_phone
     * - [Email] => contact_email
     * - [ContactPerson] => contact_person
     * - [WebSite] => website
     * - [HasVolunteering] => accepts_volunteers
     * - [WhyVolunteer] => why_volunteer
     * - [ONGStatusId] => {
     *      1	Approval -> X
     *      2	Active   -> OrganizationStatus::approved
     *      3	Inactive -> OrganizationStatus::rejected
     *   }
     * - [ONGApprovalStatusTypeId] => ?
     * - [CreationDate] => created_at
     * - [HasChanges] => ?
     * - [MerchantId] => eu_platesc_merchant_id
     * - [MerchantKey] => eu_platesc_private_key
     * - [AllCounties] => X
     * - [OrganizationalStatusId] => ?
     * - [Tags] => x
     * - [FacebookPageLink] => facebook
     * - [DynamicUrl] => slug
     */
    protected function importOrganizations(int $chunk = 5): void
    {
        $query = $this->db
            ->table('dbo.ONGs')
            ->orderBy('Id');

        $total = $query->count();

        $progressBar = $this->createProgressBar('Importing organizations...', $total);

        /** @var Collection */
        $duplicates = (clone $query)
            ->select(['Id', 'CIF', 'ONGStatusId'])
            ->addSelect([
                'projects_count' => DB::connection('import')
                    ->table('dbo.ONGProjects')
                    ->whereColumn('ONGs.Id', 'ONGProjects.ONGId')
                    ->selectRaw('count(*)'),
            ])
            ->get()
            ->groupBy('CIF')
            ->reject(fn ($collection) => $collection->count() < 2);

        $query->chunk($chunk, function (Collection $items, int $page) use ($total, $chunk, $progressBar, $duplicates) {
            $items->map(function (object $row) use ($duplicates) {
                if ($duplicates->has($row->CIF)) {
                    $organization = $duplicates->get($row->CIF)
                        ->sortBy([
                            ['ONGStatusId', 'asc'],
                            ['projects_count', 'desc'],
                        ])
                        ->first();

                    if ($organization->Id !== $row->Id) {
                        return;
                    }
                }

                $organization = Organization::create([
                    'id' => $row->Id,
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
                    'created_at' => Carbon::parse($row->CreationDate),
                    'updated_at' => Carbon::parse($row->CreationDate),
                    'eu_platesc_merchant_id' => Sanitize::text($row->MerchantId),
                    'eu_platesc_private_key' => Sanitize::text($row->MerchantKey),
                ]);

                // Add logo
                $logo = $this->db
                    ->table('dbo.Files')
                    ->join('dbo.FilesData', 'dbo.FilesData.Id', 'dbo.Files.Id')
                    ->where('dbo.Files.Id', $row->LogoImageId)
                    ->first();

                if ($logo) {
                    $organization->addMediaFromString($logo->Data)
                        ->usingFileName($logo->FileName . $logo->FileExtension)
                        ->usingName($logo->FileName . $logo->FileExtension)
                        ->toMediaCollection('logo');
                }

                // Add statute
                $statute = $this->db
                    ->table('dbo.Files')
                    ->join('dbo.FilesData', 'dbo.FilesData.Id', 'dbo.Files.Id')
                    ->where('dbo.Files.Id', $row->OrganizationalStatusId)
                    ->first();

                if ($statute) {
                    $organization->addMediaFromString($statute->Data)
                        ->usingFileName($statute->FileName . $statute->FileExtension)
                        ->usingName($statute->FileName . $statute->FileExtension)
                        ->toMediaCollection('statute');
                }
            });

            $progressBar->advance($chunk);
        });
    }

    /**
     *  Import users.
     *
     * - Id => id
     * - FirstName + LastName => name
     * - Email => email
     * - Password => old_password
     * - PasswordSalt => old_salt
     * - CreationDate => created_at
     * - ActivationCodeGeneratedDate => email_verified_at
     * - RoleId => {
     *     1 => UserRole::USER
     *     2 => UserRole::ADMIN => needs organization_id from `dbo.UserONGs`
     *     3 => UserRole::SUPERADMIN
     *  }
     */
    protected function importUsers(int $chunk = 100): void
    {
        $query = $this->db
            ->table('user.Users')
            ->where('IsActivated', 1)
            ->orderBy('Id');

        $total = $query->count();

        $progressBar = $this->createProgressBar('Importing users...', $total);

        $query->chunk($chunk, function (Collection $items, int $page) use ($total, $chunk, $progressBar) {
            $progressBar->advance($chunk);

            User::upsert(
                $items->map(fn (object $row) => [
                    'id' => $row->Id,
                    'name' => $row->FirstName . ' ' . $row->LastName,
                    'email' => $row->Email,
                    'old_password' => $row->Password,
                    'old_salt' => $row->PasswordSalt,
                    'created_at' => Carbon::parse($row->CreationDate),
                    'updated_at' => $row->ActivationCodeGeneratedDate,
                    'password_set_at' => $row->ActivationCodeGeneratedDate,
                    'email_verified_at' => $row->IsActivated ? $row->ActivationCodeGeneratedDate : null,
                    'role' => match ($row->RoleId) {
                        1 => UserRole::USER,
                        2 => UserRole::ADMIN,
                        3 => UserRole::SUPERADMIN,
                    },
                ])->all(),
                'email'
            );
        });

        $progressBar->finish();
    }

    /**
     * Import activity domains.
     * - Id => id
     * - Name => name
     * - Slug => slug.
     */
    private function importActivityDomains(int $chunk = 100): void
    {
        $query = $this->db
            ->table('lkp.ActivityDomains')
            ->orderBy('Id');

        $total = $query->count();

        $progressBar = $this->createProgressBar('Importing activity domains...', $total);
        $query->chunk($chunk, function (Collection $items) use ($total, $chunk, $progressBar) {
            $progressBar->advance($chunk);
            ActivityDomain::upsert(
                $items->map(fn (object $row) => [
                    'id' => $row->Id,
                    'name' => $row->Name,
                    'slug' => Str::slug($row->Name),
                ])->all(),
                'id'
            );
            $progressBar->finish();
        });
    }
}
