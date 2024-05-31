<?php

namespace App\Console\Commands;

use App\Enums\EuPlatescStatus;
use App\Models\Organization;
use App\Services\EuPlatescService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ProcessEuPlatescTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-eu-platesc-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $organizations = $this->getOrganizationsWithOpenDonations();

        Log::info('Processing EuPlatesc transactions'.count($organizations));
        foreach ($organizations as $organization) {
            $organizationID = $organization->id;
            $service = new EuPlatescService($organizationID);
            if (!$service->canCaptureTransaction()) {
                continue;
            }

            foreach ($organization->donations as $donation) {
                if ($service->recipeTransaction($donation)) {
                    $donation->update(['status' => EuPlatescStatus::CAPTURE]);
                }
            }
        }
    }

    private function getOrganizationsWithOpenDonations(): Collection|array
    {
        return Organization::query()
            ->withWhereHas('donations', fn ($query) => $query->whereNotNull('ep_id')->where('donations.status', EuPlatescStatus::AUTHORIZED))
            ->get();

    }

}
