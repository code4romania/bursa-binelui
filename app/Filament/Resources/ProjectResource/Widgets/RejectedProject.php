<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Widgets;

use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\ProjectResource\Actions\Tables\Projects\ApproveProjectAction;
use App\Models\Project;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;

class RejectedProject extends BaseProjectWidget
{
    protected $listeners = [
        'refreshRejectedProjectWidget' => '$refresh',
    ];

    protected function getTableHeading(): string
    {
        return __('project.heading.rejected', ['number' => $this->getTableQuery()->count()]);
    }

    protected function getTableQuery(): Builder
    {
        return Project::query()->select([
            'id',
            'organization_id',
            'slug',
            'name',
            'target_budget',
            'is_national',
            'created_at',
            'status_updated_at',
            'status',
        ])->whereIsRejected();
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'rejected_project';
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
            ViewAction::make()->label(__('project.actions.view'))
                ->iconButton()
                ->url($this->getTableRecordUrlUsing()),
            EditAction::make()
                ->url(fn (Project $record) => ProjectResource::getUrl('edit', ['record' => $record]))
                ->iconButton(),
            ApproveProjectAction::make()
                ->iconButton(),
        ];
    }
}
