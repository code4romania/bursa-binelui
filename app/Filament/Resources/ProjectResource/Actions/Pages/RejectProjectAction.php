<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Actions\Pages;

use App\Models\Organization;
use App\Models\Project;
use Filament\Forms\Components\Textarea;
use Filament\Pages\Actions\Action;

class RejectProjectAction extends Action
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

        $this->label(__('project.actions.reject'));

        $this->requiresConfirmation();

        $this->modalHeading(__('project.reject_modal.heading'));

        $this->modalSubheading(
            fn (Project $record) => __('project.reject_modal.subheading', [
                'name' => $record->name,
            ])
        );

        $this->form([
            Textarea::make('reason')
                ->label(__('project.reject_modal.reason'))
                ->required(),
        ]);

        $this->modalButton(__('project.actions.reject'));

        $this->action(function (Project $record, array $data) {
            $reason = strip_tags($data['reason']);

            $record->markAsRejected($reason);
        });
    }
}
