<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Tables\Organizations;

use App\Models\Organization;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;
use Livewire\Component;

class RejectOrganizationAction extends Action
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

        $this->form([
            Textarea::make('reason')
                ->label(__('organization.reject_modal.reason'))
                ->required(),
        ]);

        $this->modalButton(__('organization.actions.reject'));

        $this->action(function (Organization $record, array $data) {
            $reason = strip_tags($data['reason']);

            $record->markAsRejected($reason);
        });

        $this->after(fn (Component $livewire) => $livewire->emit('refreshRejectedOrganizationsWidget'));
    }
}
