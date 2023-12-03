<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use App\Enums\EuPlatescStatus;
use App\Models\Donation;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Throwable;

class ImportDonationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:donations
        {--chunk=100 : The number of records to process at a time}
        {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import donations from the old database.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Donation::truncate();

        if (! $this->confirmToProceed()) {
            return static::FAILURE;
        }

        $query = $this->db
            ->table('dbo.Donations')
            ->orderBy('dbo.Donations.Id');

        $this->createProgressBar('Importing donations...', $query->count());
        $projectsIds = Project::get()->pluck('id');

        $query->chunk((int) $this->option('chunk'), function (Collection $items) use ($projectsIds) {
            $items
                ->reject(fn (object $row) => $this->getRejectedOrganizations()->contains($row->ONGId))
                ->reject(fn (object $row) => $projectsIds->doesntContain($row->ONGProjectId))
                ->each(function (object $row) {
                    try {
                        $created_at = Carbon::parse($row->CreationDate);
                        Donation::forceCreate(
                            [
                                'id' => (int) $row->Id,
                                'project_id' => (int) $row->ONGProjectId,
                                'user_id' => $row->UserId,
                                'organization_id' => (int) $row->ONGId,
                                'amount' => (float) $row->Amount,
                                'charge_amount' => (float) $row->ChargedAmount,
                                'first_name' => $row->FirstName ?? '',
                                'last_name' => $row->LastName ?? '',
                                'email' => $row->Email ?? '',
                                'card_holder_status_message' => $row->CaldHolderStatusMessage,
                                'created_at' => $created_at,
                                'approval_date' => Carbon::parse(Str::replace(':AM', '', $row->ApprovedDate)),
                                'charge_date' => Carbon::parse(Str::replace(':AM', '', $row->ChargedDate)),
                                'updated_without_correct_e_pid' => (bool) $row->UpdatedWithoutCorrectEpId,
                                'status' => match ($row->DonationStatusTypeId) {
                                    1 => EuPlatescStatus::INITIALIZE,
                                    2 => EuPlatescStatus::AUTHORIZED,
                                    3 => EuPlatescStatus::UNAUTHORIZED,
                                    4 => EuPlatescStatus::ABORTED,
                                    5 => EuPlatescStatus::CHARGED,
                                    6 => EuPlatescStatus::POSSIBLE_FRAUD,
                                    7 => EuPlatescStatus::PAYMENT_DECLINED,

                                    default => throw new \Exception('Invalid status: ' . $row->Status),
                                },

                            ]
                        );
                    } catch (Throwable $th) {
                        $this->logError('Error importing donation #' . $row->Id, [$th->getMessage()]);
                    }

                    $this->progressBar->advance();
                });
        });

        $this->finishProgressBar('Imported donations');

        return static::SUCCESS;
    }
}
