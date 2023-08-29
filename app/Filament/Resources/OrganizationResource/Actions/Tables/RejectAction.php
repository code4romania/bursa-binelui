<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Tables;

use App\Models\Organization;
use Filament\Tables\Actions\Action;

class RejectAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'reject';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('danger');

        $this->icon('heroicon-s-x');

        $this->label(__('organization.actions.reject'));

        $this->requiresConfirmation();

        $this->modalHeading(__('organization.reject_modal.heading'));

        $this->modalSubheading(
            fn (Organization $record) => __('organization.reject_modal.subheading', [
                'name' => $record->name,
            ])
        );

        $this->modalButton(__('organization.actions.reject'));

        $this->action(function (Organization $record) {
            $record->markAsRejected();
        });
    }
}
