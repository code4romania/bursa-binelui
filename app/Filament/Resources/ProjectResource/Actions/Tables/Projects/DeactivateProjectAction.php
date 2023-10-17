<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Actions\Tables\Projects;

use App\Models\Project;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;
use Livewire\Component;

class DeactivateProjectAction extends Action
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

        $this->label(__('project.actions.deactivate'));

        $this->requiresConfirmation();

        $this->modalHeading(__('project.deactivate_modal.heading'));

        $this->modalSubheading(
            fn (Project $record) => __('project.deactivate_modal.subheading', [
                'name' => $record->name,
            ])
        );

        $this->form([
            Textarea::make('reason')
                ->label(__('project.deactivate_modal.reason'))
                ->required(),
        ]);

        $this->modalButton(__('project.actions.deactivate'));

        $this->action(function (Project $record, array $data) {
            $reason = strip_tags($data['reason']);

            $record->markAsRejected($reason);
        });

        $this->after(fn (Component $livewire) => $livewire->emit('refreshRejectedOrganizationsWidget'));
    }
}
