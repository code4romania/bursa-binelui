<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions;

use App\Enums\OrganizationStatus;
use App\Models\Organization;
use Filament\Tables\Actions\Action;

class ApproveAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('organization.actions.approve'));
        $this->requiresConfirmation();
        $this->modalHeading(__('organization.actions.approve'));
        $this->modalButton(__('organization.actions.approve'));
        $this->action(function (Organization $record) {
            $record->update(['status' => OrganizationStatus::approved]);
        });
    }
}
