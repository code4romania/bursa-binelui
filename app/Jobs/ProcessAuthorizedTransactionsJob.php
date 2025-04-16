<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Donation;
use App\Models\Organization;
use App\Services\EuPlatescService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAuthorizedTransactionsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('Processing authorized transactions started at ' . now()->toString());
        $counter = 0;
        Organization::query()
            ->whereHasEuPlatesc()
            ->withWhereHas('donations', function (Builder $query) {
                return $query
                    ->whereAuthorized()
                    ->whereNotNull('ep_id');
            })
            ->get()
            ->each(function (Organization $organization) use (&$counter) {
                $service = new EuPlatescService($organization);

                $organization->donations
                    ->each(fn (Donation $donation) => CaptureAuthorizedDonationJob::dispatch($donation, $service));
                $counter++;
            });
        \Log::info('Processing authorized transactions ended at ' . now()->toString() . ' with ' . $counter . ' organization processed.');
    }
}
