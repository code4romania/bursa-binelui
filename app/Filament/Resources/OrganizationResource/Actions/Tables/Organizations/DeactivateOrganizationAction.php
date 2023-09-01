<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Tables\Organizations;

use App\Models\Organization;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;

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

        $this->form([
            Textarea::make('reason')
                ->label(__('organization.deactivate_modal.reason'))
                ->required(),
        ]);

        $this->modalButton(__('organization.actions.deactivate'));

        $this->action(function (Organization $record, array $data) {
            $reason = strip_tags($data['reason']);

            $record->markAsRejected($reason);
        });
    }
}
