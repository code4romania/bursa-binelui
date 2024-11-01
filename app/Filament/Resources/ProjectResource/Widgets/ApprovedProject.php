<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Widgets;

use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\ProjectResource\Actions\Tables\Projects\RejectProjectAction;
use App\Models\Project;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class ApprovedProject extends BaseProjectWidget
{
//    protected static string $view = 'filament.resources.project-resource.widgets.new-project';

    protected function getTableHeading(): string
    {
        return __('project.heading.approved', ['number' => $this->getTableQuery()->count()]);
    }

    protected function getTableQuery(): Builder
    {
        return Project::query()->select([
            'id',
            'organization_id',
            'name',
            'target_budget',
            'is_national',
            'created_at',
            'status_updated_at',
            'archived_at',
            'start',
            'end',
            'slug',
            'status',
        ])->whereIsApproved();
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'approved_project';
    }

    protected function getTableRecordUrlUsing(): \Closure
    {
        return function (Project $record) {
            return route('filament.resources.projects.view', $record);
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
            RejectProjectAction::make()
                ->iconButton(),
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->formatStateUsing(function (Project $record) {
                    return sprintf('#%d', $record->id);
                })
                ->label(__('project.labels.id'))
                ->sortable(),

            BadgeColumn::make('visible_status')
                ->label('status')
                ->formatStateUsing(
                    fn (Project $record) => __(sprintf('project.visible_status.%s', $record->visible_status))
                )
                ->colors(
                    [
                        'primary' => 'published',
                        'success' => 'open',
                        'warning' => 'starting_soon',
                        'info' => 'archived',
                        'danger' => 'close',
                    ]
                ),

            TextColumn::make('name')
                ->description(fn (Project $record) => $record->organization->name)
                ->searchable(),

            TextColumn::make('category')
                ->formatStateUsing(
                    fn (Project $record) => $record
                        ->categories
                        ->pluck('name')
                        ->join(', ')
                )
                ->label(__('project.labels.category')),

            TextColumn::make('counties')
                ->formatStateUsing(
                    function (Project $record) {
                        if ($record->is_national) {
                            return __('project.labels.national');
                        }

                        return $record->counties->pluck('name')->join(', ');
                    }
                )
                ->label(__('project.labels.counties')),

            TextColumn::make('target_budget')
                ->formatStateUsing(
                    fn (Project $record) => number_format($record->target_budget, 2, ',', '.')
                )
                ->label(__('project.labels.target_budget')),

            TextColumn::make('status_updated_at')
                ->date('d-m-Y H:i:s')
                ->label(__('project.labels.status_updated_at')),

            TextColumn::make('created_at')
                ->date('d-m-Y H:i:s')
                ->label(__('project.labels.created_at')),
        ];
    }
}
