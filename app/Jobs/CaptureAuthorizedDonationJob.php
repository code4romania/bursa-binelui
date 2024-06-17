<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\EuPlatescStatus;
use App\Models\Donation;
use App\Services\EuPlatescService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CaptureAuthorizedDonationJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public Donation $donation;

    public EuPlatescService $service;

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 3600;

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): int
    {
        return $this->donation->id;
    }

    public function __construct(Donation $donation, EuPlatescService $service)
    {
        $this->donation = $donation;
        $this->service = $service;
    }

    public function handle(): void
    {
        if ($this->service->recipeTransaction($this->donation)) {
            $this->donation->update([
                'status' => EuPlatescStatus::CHARGED,
                'status_updated_at' => now(),
            ]);
        }
    }
}
