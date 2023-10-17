<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Actions\Tables\Projects;

use App\Models\Organization;
use App\Models\Project;
use Filament\Tables\Actions\Action;
use Livewire\Component;

class ApproveProjectAction extends Action
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

        $this->label(__('project.actions.approve'));

        $this->requiresConfirmation();

        $this->modalHeading(__('project.approve_modal.heading'));

        $this->modalSubheading(
            fn (Project $record) => __('project.approve_modal.subheading', [
                'name' => $record->name,
            ])
        );

        $this->modalButton(__('project.actions.approve'));

        $this->action(function (Project $record) {
            $record->markAsApproved();
        });

        $this->after(fn (Component $livewire) => $livewire->emit('refreshApprovedOrganizationsWidget'));
    }
}
