<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Helper\ProgressBar;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import';

    private ?Connection $sourceConnection = null;

    private ProgressBar $progressBar;

    private int $chunk = 200;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->progressBar = $this->output->createProgressBar(7);
        $this->progressBar->setFormat('%current%/%max% [%bar%] %message%');
        $this->progressBar->start();

        $this->truncateTables();

        $this->importOrganizations();
        $this->importUsers();

        $this->progressBar->setMessage('Done!');
        $this->progressBar->finish();
        $this->info('');

        return static::SUCCESS;
    }

    protected function getSourceConnection()
    {
        if (\is_null($this->sourceConnection)) {
            $this->sourceConnection = DB::connection('import');
        }

        return $this->sourceConnection;
    }

    protected function truncateTables(): void
    {
        $this->progressBar->setMessage('Truncating tables...');
        $this->progressBar->advance();

        Schema::withoutForeignKeyConstraints(function () {
            User::truncate();
            Organization::truncate();
        });
    }

    private function addMaxSteps(int|float $count): void
    {
        $this->progressBar->setMaxSteps(
            $this->progressBar->getMaxSteps() + (int) ceil($count)
        );
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
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function importUsers(): void
    {
        $this->progressBar->setMessage('Importing users...');
        $this->progressBar->advance();

        $query = $this->getSourceConnection()
            ->table('user.Users')
            ->where('IsActivated', 1)
            ->orderBy('Id');

        $total = $query->count();

        $this->addMaxSteps($total / $this->chunk);

        $query->chunk($this->chunk, function (Collection $items, int $page) use ($total) {
            $this->progressBar->setMessage(sprintf(
                'Importing users %d/%d',
                $page * $this->chunk,
                $total
            ));

            $this->progressBar->advance($this->chunk);

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
     * - [Address] => street_address
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
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function importOrganizations(): void
    {
        $this->progressBar->setMessage('Importing organizations...');
        $this->progressBar->advance();

        $query = $this->getSourceConnection()
            ->table('dbo.ONGs')
            ->where('ONGStatusId', 2)
            ->orderBy('Id');

        $total = $query->count();

        $this->addMaxSteps($total / $this->chunk);

        $query->chunk($this->chunk, function (Collection $items, int $page) use ($total) {
            $this->progressBar->setMessage(sprintf(
                'Importing organizations %d/%d',
                $page * $this->chunk,
                $total
            ));

            $items->map(fn (object $row) => Organization::create([
                'id' => $row->Id,
                'name' => $row->Name,
                'description' => $row->Description,
                'cif' => $row->CIF,
                'street_address' => $row->Address,
                'contact_phone' => $row->PhoneNb,
                'contact_email' => $row->Email,
                'contact_person' => $row->ContactPerson,
                'website' => $row->WebSite,
                'accepts_volunteers' => $row->HasVolunteering,
                'why_volunteer' => $row->WhyVolunteer,
            ]));

            $this->progressBar->advance($this->chunk);
        });
    }
}
