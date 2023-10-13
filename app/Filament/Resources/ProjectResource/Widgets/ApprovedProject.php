<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Widgets;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class ApprovedProject extends BaseProjectWidget
{
//    protected static string $view = 'filament.resources.project-resource.widgets.new-project';

    protected function getTableHeading(): string
    {
        return __('project.heading.approved',['number' => $this->getTableQuery()->count()]);
    }

    protected function getTableQuery(): Builder
    {
        return Project::query()->select(['id','organization_id','name','target_budget','is_national','created_at','status_updated_at','status'])->whereIsApproved();
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'approved_project';
    }

    protected function getTableRecordUrlUsing(): \Closure
    {
        return function (Project $record) {
            return route('filament.resources.projects.edit', $record);
        };
    }

    protected function getTableActions(): array
    {
        return [
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
