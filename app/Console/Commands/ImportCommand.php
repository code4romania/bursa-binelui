<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\OrganizationStatus;
use App\Enums\UserRole;
use App\Models\Organization;
use App\Models\User;
use App\Services\Sanitize;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Commands\CleanCommand;
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

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->cleanup();

        $this->importOrganizations();
        $this->importUsers();

        return static::SUCCESS;
    }

    protected function cleanup(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            $models = [
                Media::class,
                User::class,
                Organization::class,
            ];

            $progressBar = $this->createProgressBar('Removing old data...', \count($models));

            foreach ($progressBar->iterate($models) as $model) {
                $model::truncate();
            }

            Artisan::call(CleanCommand::class);

            $progressBar->finish();
        });
    }

    /**
     * Import organizations.
     *
     * - [Id] => id
     * - [Name] => name
     * - [LogoImageId] => media library -> logo collection
     * - [Description] => description
     * - [AnualReportFileId] => media library -> default collection
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
     *      1	Approval -> OrganizationStatus::pending
     *      2	Active   -> OrganizationStatus::approved
     *      3	Inactive -> OrganizationStatus::rejected
     *   }
     * - [ONGApprovalStatusTypeId] => ?
     * - [CreationDate] => created_at
     * - [HasChanges] => ?
     * - [MerchantId] => eu_platesc_merchant_id
     * - [MerchantKey] => eu_platesc_private_key
     * - [AllCounties] => X
     * - [OrganizationalStatusId] => media library -> statute collection
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

        $query->chunk($chunk, function (Collection $items) use ($progressBar, $duplicates) {
            $items->map(function (object $row) use ($duplicates, $progressBar) {
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

                $created_at = Carbon::parse($row->CreationDate);

                $organization = Organization::forceCreate([
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
                    'status_updated_at' => $created_at,
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                    'eu_platesc_merchant_id' => Sanitize::text($row->MerchantId),
                    'eu_platesc_private_key' => Sanitize::text($row->MerchantKey),
                ]);

                // Add logo
                $this->addFileToCollection(
                    $this->db
                        ->table('dbo.Files')
                        ->join('dbo.FilesData', 'dbo.FilesData.Id', 'dbo.Files.Id')
                        ->where('dbo.Files.Id', $row->LogoImageId)
                        ->first(),
                    $organization,
                    'logo'
                );

                // Add statute
                $this->addFileToCollection(
                    $this->db
                        ->table('dbo.Files')
                        ->join('dbo.FilesData', 'dbo.FilesData.Id', 'dbo.Files.Id')
                        ->where('dbo.Files.Id', $row->OrganizationalStatusId)
                        ->first(),
                    $organization,
                    'statute'
                );

                // Add annual report
                $this->addFileToCollection(
                    $this->db
                        ->table('dbo.Files')
                        ->join('dbo.FilesData', 'dbo.FilesData.Id', 'dbo.Files.Id')
                        ->where('dbo.Files.Id', $row->AnualReportFileId)
                        ->first(),
                    $organization,
                );

                $progressBar->advance();
            });
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

        $query->chunk($chunk, function (Collection $items) use ($chunk, $progressBar) {
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

            $progressBar->advance($chunk);
        });

        $progressBar->finish();
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

    private function addFileToCollection(object|null $file, Model $model, string $collection = 'default'): void
    {
        if (! $file) {
            return;
        }

        $filename = rtrim($file->FileName, '.') . '.' . ltrim($file->FileExtension, '.');

        $model->addMediaFromString($file->Data)
            ->usingFileName($filename)
            ->usingName($filename)
            ->toMediaCollection($collection);
    }
}
