<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions;

use App\Enums\OrganizationStatus;
use App\Models\Organization;
use Filament\Tables\Actions\Action;

class RejectAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('organization.actions.reject'));
        $this->requiresConfirmation();
        $this->modalHeading(__('organization.actions.reject'));
        $this->modalButton(__('organization.actions.reject'));
        $this->action(function (Organization $record) {
            $record->update(['status' => OrganizationStatus::rejected]);
        });
    }
}
