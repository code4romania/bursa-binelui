<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Widgets;

use App\Enums\OrganizationStatus;
use App\Filament\Resources\OrganizationResource;
use App\Filament\Resources\OrganizationResource\Actions\Tables\ExportAction;
use App\Models\Organization;
use App\Tables\Columns\TitleWithImageColumn;
use Filament\Tables\Columns\TextColumn;
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
}
