<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Actions\Pages;

use App\Models\Project;
use Filament\Pages\Actions\Action;

class ReactivateProjectAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'reactivate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('success');

        $this->icon('heroicon-s-check');

        $this->label(__('project.actions.reactivate'));

        $this->requiresConfirmation();

        $this->modalHeading(__('project.reactivate_modal.heading'));

        $this->modalSubheading(
            fn (Project $record) => __('project.reactivate_modal.subheading', [
                'name' => $record->name,
            ])
        );

        $this->modalButton(__('project.actions.reactivate'));

        $this->action(function (Project $record) {
            $record->markAsApproved();
        });
    }
}
