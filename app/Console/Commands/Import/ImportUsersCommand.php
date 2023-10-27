<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ImportUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:users {--chunk=300 : The number of records to process at a time}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from the old database.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $query = $this->db
            ->table('user.Users')
            ->where('user.Users.IsActivated', 1)
            ->leftJoin('dbo.ONGAdministrators', 'dbo.ONGAdministrators.UserId', 'user.Users.Id')
            ->select([
                'user.Users.*',
                'dbo.ONGAdministrators.ONGId',
            ])
            ->orderBy('user.Users.Id');

        $this->createProgressBar('Importing users...', $query->count());

        $chunk = (int) $this->option('chunk');

        $query->chunk($chunk, function (Collection $items) use ($chunk) {
            User::upsert(
                $items
                    ->reject(fn (object $row) => $this->getRejectedOrganizations()->contains($row->ONGId))
                    ->map(fn (object $row) => [
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
                        'organization_id' => match ($row->RoleId) {
                            2 => $row->ONGId,
                            default => null,
                        },
                    ])->all(),
                'email'
            );

            $this->progressBar->advance($chunk);
        });

        $this->progressBar->finish();

        return static::SUCCESS;
    }
}
