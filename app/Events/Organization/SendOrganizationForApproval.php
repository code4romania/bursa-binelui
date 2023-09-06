<?php

declare(strict_types=1);

namespace App\Events\Organization;

use App\Models\Organization;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendOrganizationForApproval
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Organization $organization;

    /**
     * Create a new event instance.
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }
}
