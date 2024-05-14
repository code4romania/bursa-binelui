<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use App\Enums\VolunteerStatus;
use App\Models\Volunteer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ImportVolunteersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:volunteers
        {--chunk=100 : The number of records to process at a time}
        {--skip-files : Skip importing files}
        {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import volunteers from the old database.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return static::FAILURE;
        }

        $this->importVolunteers();

        return static::SUCCESS;
    }

    protected function importVolunteers(): void
    {
        $volunteers = $this->db
            ->table('dbo.Volunteers')
            ->orderBy('dbo.Volunteers.Email');

        $this->createProgressBar('Importing volunteers....', $volunteers->count());
        $volunteers->chunk((int) $this->option('chunk'), function (Collection $volunteers) {
            $volunteers->groupBy('Email')->each(function ($volunteer) {
                $tmpData = $volunteer->first();
                $createdDate = Carbon::parse($tmpData->CreationDate);
                $insertedVolunteer = Volunteer::forceCreate(
                    [
                        'email' => $tmpData->Email,
                        'name' => $tmpData->FirstName . ' ' . $tmpData->LastName,
                        'phone' => $tmpData->Phone ?? ' ',
                        'created_at' => $createdDate,
                        'updated_at' => $createdDate,
                        'user_id' => $tmpData->UserId ?? null,
                    ]
                );
                foreach ($volunteer as $vol) {
                    $insertedVolunteer->projects()->attach($vol->ProjectId, ['status' => VolunteerStatus::APPROVED, 'created_at' => Carbon::parse($vol->CreationDate)]);
                    $insertedVolunteer->organizations()->attach($vol->ONGId, ['status' => VolunteerStatus::APPROVED, 'created_at' => Carbon::parse($vol->CreationDate)]);
                }
            });
            $this->progressBar->advance($volunteers->count());
        });

        $this->finishProgressBar('Imported volunteers.');
    }
}
