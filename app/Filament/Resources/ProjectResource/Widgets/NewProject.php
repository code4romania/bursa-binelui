<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Widgets;

use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\ProjectResource\Actions\Tables\Projects\ApproveProjectAction;
use App\Filament\Resources\ProjectResource\Actions\Tables\Projects\RejectProjectAction;
use App\Models\Project;
use Filament\Tables\Actions\EditAction;
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
        return __('project.heading.pending', ['number' => $this->getTableQuery()->count()]);
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
        ])->whereIsPending();
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'new_project';
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make()->label(__('project.actions.view'))
                ->iconButton()
                ->url($this->getTableRecordUrlUsing()),
            EditAction::make('edit')
                ->url(fn (Project $record) => ProjectResource::getUrl('edit', ['record' => $record]))
                ->iconButton(),
            ApproveProjectAction::make()
                ->iconButton(),
            RejectProjectAction::make()
                ->iconButton(),
        ];
    }
}
