<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\UserRole;
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
        });
    }

    private function addMaxSteps(int $count): void
    {
        $this->progressBar->setMaxSteps(
            $this->progressBar->getMaxSteps() + $count
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

        $this->getSourceConnection()
            ->table('user.Users')
            ->where('IsActivated', 1)
            ->orderBy('Id')
            ->chunk($this->chunk, function (Collection $items, int $page) use ($total) {
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
}
