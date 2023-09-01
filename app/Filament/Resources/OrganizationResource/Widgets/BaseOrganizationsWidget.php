<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Widgets;

use App\Enums\OrganizationStatus;
use App\Filament\Resources\OrganizationResource;
use App\Filament\Resources\OrganizationResource\Actions\Tables\ExportAction;
use App\Models\Organization;
use App\Tables\Columns\TitleWithImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseOrganizationsWidget extends BaseWidget
{
    protected static string $resource = OrganizationResource::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected function getTableQuery(): Builder
    {
        return Organization::query()
            ->with(['media'])
            ->select([
                'id',
                'name',
                'created_at',
                'updated_at',
                'status_updated_at',
                'status',
            ]);
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'id';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->status(match (\get_class($this)) {
                    PendingOrganizationsWidget::class => OrganizationStatus::pending,
                    ApprovedOrganizationsWidget::class => OrganizationStatus::approved,
                    PendingChangesOrganizationsWidget::class => OrganizationStatus::pending_changes,
                    RejectedOrganizationsWidget::class => OrganizationStatus::rejected,
                }),
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            TitleWithImageColumn::make('name')
                ->label(__('organization.organization'))
                ->image(fn ($record) => $record->cover_image)
                ->description(
                    fn ($record) => sprintf(
                        '%s: %s',
                        __('field.updated_at'),
                        $record->updated_at->toFormattedDateTime()
                    )
                )
                ->searchable(),

            TextColumn::make('status_updated_at')
                ->label(__('organization.labels.status_updated_at'))
                ->dateTime()
                ->sortable(),
        ];
    }

    protected function getTableRecordUrlUsing(): \Closure
    {
        return fn (Organization $record) => OrganizationResource::getUrl('view', $record);
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->simplePaginate(
            $this->getTableRecordsPerPage() == -1 ? $query->count() : $this->getTableRecordsPerPage(),
            ['*'],
            $this->getTablePaginationPageName(),
        );
    }

    public static function getResource(): string
    {
        return static::$resource;
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('counties')
                ->relationship('counties', 'name')
                ->label(__('organization.filters.counties'))
                ->placeholder(__('organization.filters.counties_placeholder'))
                ->multiple(),

            SelectFilter::make('activity_domains')
                ->relationship('activityDomains', 'name')
                ->label(__('organization.filters.activity_domains'))
                ->placeholder(__('organization.filters.activity_domains_placeholder'))
                ->multiple(),

            Filter::make('accepts_volunteers')
                ->toggle()
                ->label(__('organization.filters.accepts_volunteers'))
                ->query(fn (Builder $query) => $query->whereAcceptsVolunteers()),

            Filter::make('has_volunteers')
                ->toggle()
                ->label(__('organization.filters.has_volunteers'))
                ->query(fn (Builder $query) => $query->whereHasVolunteers()),

            Filter::make('has_projects')
                ->toggle()
                ->label(__('organization.filters.has_projects'))
                ->query(fn (Builder $query) => $query->whereHasProjects()),

            Filter::make('has_active_projects')
                ->toggle()
                ->label(__('organization.filters.has_active_projects'))
                ->query(fn (Builder $query) => $query->whereHasActiveProjects()),

            Filter::make('has_eu_platesc')
                ->toggle()
                ->label(__('organization.filters.has_eu_platesc'))
                ->query(fn (Builder $query) => $query->whereHasEuPlatesc()),

            Filter::make('has_donations')
                ->toggle()
                ->label(__('organization.filters.has_donations'))
                ->query(fn (Builder $query) => $query->whereHasDonations()),

        ];
    }
//    protected function getTableFiltersLayout(): ?string
//    {
//        return  Layout::AboveContent;
//    }
}
