<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Tables;

use App\Models\Organization;
use Filament\Tables\Actions\Action;

class ApproveAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'approve';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('success');

        $this->icon('heroicon-s-check');

        $this->label(__('organization.actions.approve'));

        $this->requiresConfirmation();

        $this->modalHeading(__('organization.approve_modal.heading'));

        $this->modalSubheading(
            fn (Organization $record) => __('organization.approve_modal.subheading', [
                'name' => $record->name,
            ])
        );

        $this->modalButton(__('organization.actions.approve'));

        $this->action(function (Organization $record) {
            $record->markAsApproved();
        });
    }
}
