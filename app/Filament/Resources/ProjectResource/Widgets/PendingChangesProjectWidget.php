<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Widgets;

use App\Filament\Filters\DateFilter;
use App\Models\Activity;
use App\Models\Organization;
use App\Models\Project;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class PendingChangesProjectWidget extends BaseProjectWidget
{
    protected function getTableHeading(): string
    {
        return __('project.heading.pending_changes', ['number' => $this->getTableQuery()->count()]);
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->whereHas('activities', function (Builder $query) {
                $query->wherePending();
            })
            ->withCount([
                'activities' => fn (Builder $query) => $query->wherePending(),
            ])
            ->addSelect([
                'latest_updated_at' => Activity::query()
                    ->withoutGlobalScopes()
                    ->wherePending()
                    ->select('created_at')
                    ->whereColumn('subject_id', 'projects.id')
                    ->whereMorphedTo('subject', Organization::class)
                    ->latest()
                    ->take(1),
            ])
            ->withCasts([
                'latest_updated_at' => 'datetime',
            ]);
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'pending_changes';
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label(__('field.id'))
                ->formatStateUsing(
                    fn ($state) => __('field.id_format', ['number' => $state])
                )
                ->sortable(),
            TextColumn::make('id')
                ->formatStateUsing(function (Project $record) {
                    return sprintf('#%d', $record->id);
                })
                ->label(__('project.labels.id'))
                ->sortable(),

            TextColumn::make('name')
                ->description(fn (Project $record) => $record->organization->name)
                ->searchable(),

            TextColumn::make('activities_count')
                ->label(__('project.labels.changes_count'))
                ->sortable(),

            TextColumn::make('latest_updated_at')
                ->label(__('project.labels.latest_updated_at'))
                ->dateTime()
                ->sortable(),
        ];
    }

    protected function getTableRecordUrlUsing(): \Closure
    {
        return function (Project $record) {
            return  route('filament.resources.projects.view', ['record' => $record, 'activeRelationManager' => 2]);
        };
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make()
                ->label(__('project.actions.view'))
                ->iconButton()
                ->url($this->getTableRecordUrlUsing()),
        ];
    }

    protected function getTableFilters(): array
    {
        return array_merge([DateFilter::make('latest_updated_at')->label(__('project.filters.status_updated_between'))], parent::getTableFilters());
    }
}
