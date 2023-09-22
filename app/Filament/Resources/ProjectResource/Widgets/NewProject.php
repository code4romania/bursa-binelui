<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Widgets;

use App\Enums\ProjectStatus;
use App\Filament\Resources\ProjectResource;
use App\Models\Project;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;

class NewProject extends BaseProjectWidget
{
//    protected static string $view = 'filament.resources.project-resource.widgets.new-project';
    protected static ?int $sort = 1;

    /** @var string */
    protected static string $resource = ProjectResource::class;

    protected function getTableHeading(): string
    {
        return __('project.heading.pending');
    }

    protected function getTableQuery(): Builder
    {
        return Project::query()->whereIsPending();
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'new_project';
    }

    protected function getTableActions(): array
    {
        return [

            ViewAction::make()
                ->label(__('project.actions.view'))
                ->url(fn (Project $record) => route('filament.resources.projects.edit', $record))
                ->icon(null)
                ->size('sm'),
            Action::make('edit')
                ->label(__('project.actions.edit'))
                ->url(self::getTableRecordUrlUsing())
                ->size('sm')
                ->icon(null),
            Action::make('accept')
                ->label(__('project.actions.approve'))
                ->size('sm')
                ->icon(null)
                ->action(function (Project $record) {
                    $record->status = ProjectStatus::approved->value;
                    $record->save();
                })
                ->requiresConfirmation(),
            Action::make('reject')
                ->label(__('project.actions.reject'))
                ->action(function (Project $record) {
                    $record->status = ProjectStatus::rejected->value;
                    $record->save();
                })
                ->requiresConfirmation()
                ->size('sm')
                ->icon(null),
        ];
    }
}
