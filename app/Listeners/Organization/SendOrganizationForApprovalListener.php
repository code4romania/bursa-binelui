<?php

declare(strict_types=1);

namespace App\Listeners\Organization;

use App\Events\Organization\SendOrganizationForApproval;
use App\Models\User;
use App\Notifications\Admin\OrganizationCreated as OrganizationCreatedAdmin;
use App\Notifications\Ngo\OrganizationCreated;
use Illuminate\Support\Facades\Notification;

class SendOrganizationForApprovalListener
{
    public function handle(SendOrganizationForApproval $event): void
    {
        $event->organization->markAsPending();

        Notification::send(
            User::query()
                ->onlyBBAdmins()
                ->get(),
            new OrganizationCreatedAdmin($event->organization)
        );

        Notification::send(
            User::query()
                ->onlyNGOAdmins($event->organization)
                ->get(),
            new OrganizationCreated($event->organization)
        );
    }
}
