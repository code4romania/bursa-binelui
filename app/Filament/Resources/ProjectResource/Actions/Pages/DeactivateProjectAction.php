<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Actions\Pages;

use App\Models\Project;
use Filament\Pages\Actions\Action;

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

        $this->modalButton(__('project.actions.deactivate'));

        $this->action(function (Project $record) {
            $record->markAsRejected();
        });
    }
}
