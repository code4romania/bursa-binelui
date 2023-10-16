<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Widgets;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Filament\Tables\Actions\Action;
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
                ->colors(
                    [
                        'primary' => 'published',
                        'success' => 'open',
                        'warning' => 'starting_soon',
                        'info' => 'archived',
                        'danger' => 'close',
                    ]
                )->sortable(),
            TextColumn::make('name')->description(fn (Project $record) => $record->organization->name)->searchable(),
            TextColumn::make('category')->formatStateUsing(fn (Project $record) => $record->categories->pluck('name')->join(', '))
                ->label(__('project.labels.category')),
            TextColumn::make('counties')->formatStateUsing(function (Project $record) {
                if ($record->is_national) {
                    return __('project.labels.national');
                }

                return $record->counties->pluck('name')->join(', ');
            })
                ->label(__('project.labels.counties')),
            TextColumn::make('target_budget')->formatStateUsing(function (Project $record) {
                return number_format($record->target_budget, 2, ',', '.');
            })
                ->label(__('project.labels.target_budget')),
            TextColumn::make('status_updated_at')->date('d-m-Y H:i:s')
                ->label(__('project.labels.status_updated_at')),
            TextColumn::make('created_at')->date('d-m-Y H:i:s')
                ->label(__('project.labels.created_at')),
        ];
    }
}
