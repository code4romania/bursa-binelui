<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Pages;

use App\Models\Organization;
use Filament\Pages\Actions\Action;

class DeactivateOrganizationAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'deactivate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('danger');

        $this->icon('heroicon-s-x');

        $this->label(__('organization.actions.deactivate'));

        $this->requiresConfirmation();

        $this->modalHeading(__('organization.deactivate_modal.heading'));

        $this->modalSubheading(
            fn (Organization $record) => __('organization.deactivate_modal.subheading', [
                'name' => $record->name,
            ])
        );

        $this->modalButton(__('organization.actions.deactivate'));

        $this->action(function (Organization $record) {
            $record->markAsRejected();
        });
    }
}
