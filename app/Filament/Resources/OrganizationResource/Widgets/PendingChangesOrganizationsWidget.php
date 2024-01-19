<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Widgets;

use App\Filament\Resources\OrganizationResource;
use App\Models\Activity;
use App\Models\Organization;
use App\Tables\Columns\TitleWithImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class PendingChangesOrganizationsWidget extends BaseOrganizationsWidget
{
    protected function getTableHeading(): string
    {
        return __('organization.heading.pending_changes', ['number' => $this->getTableQuery()->count()]);
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
                    ->whereColumn('subject_id', 'organizations.id')
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

            TitleWithImageColumn::make('name')
                ->label(__('organization.organization'))
                ->image(fn (Organization $record) => $record->getFirstMediaUrl('logo'))
                ->searchable()
                ->sortable(),

            TextColumn::make('activities_count')
                ->label(__('organization.labels.changes_count'))
                ->sortable(),

            TextColumn::make('latest_updated_at')
                ->label(__('organization.labels.latest_updated_at'))
                ->dateTime()
                ->sortable(),
        ];
    }

    protected function getTableRecordUrlUsing(): \Closure
    {
        return fn (Organization $record) => OrganizationResource::getUrl('view', ['record' => $record, 'activeRelationManager' => 5]);
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make()
                ->label(__('organization.actions.view'))
                ->url($this->getTableRecordUrlUsing()),
        ];
    }

    protected function getTableFilters(): array
    {
        $statusUpdateFilter = [
            Filter::make('status_updated_at')
                ->columns()
                ->form([
                    DatePicker::make('latest_updated_from')
                        ->label(__('activity.filter.logged_from'))
                        ->placeholder(
                            fn ($state): string => today()
                                ->setDay(17)
                                ->setMonth(11)
                                ->subYear()
                                ->toFormattedDate()
                        ),

                    DatePicker::make('latest_updated_until')
                        ->label(__('activity.filter.logged_until'))
                        ->after('latest_updated_from')
                        ->placeholder(
                            fn ($state): string => today()
                                ->toFormattedDate()
                        ),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query
                        ->when(
                            $data['latest_updated_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('latest_updated_at', '>=', $date),
                        )
                        ->when(
                            $data['latest_updated_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('latest_updated_at', '<=', $date),
                        );
                })
        ];

        return array_merge($statusUpdateFilter, parent::getTableFilters());
    }
}
