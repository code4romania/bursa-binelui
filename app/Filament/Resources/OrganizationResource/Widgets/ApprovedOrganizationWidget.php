<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Widgets;

use App\Enums\OrganizationStatus;
use App\Filament\Resources\OrganizationResource;
use App\Models\Organization;
use Filament\Tables\Actions\Action;
use Filament\Tables\Concerns\CanPaginateRecords;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ApprovedOrganizationWidget extends BaseWidget
{
    use CanPaginateRecords {
        paginateTableQuery as protected;
    }

    /** @var string */
    protected static string $resource = OrganizationResource::class;

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = [
        'lg' => 2,
    ];

    protected static ?string $recordTitleAttribute = 'title';

    public static function canView(): bool
    {
        return true;
    }

    protected function getTableHeading(): string
    {
        return __('organization.heading.approved');
    }

    protected function getTableQuery(): Builder
    {
        return Organization::isApproved();
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'approved_organization';
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'id';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableColumns(): array
    {
        return self::$resource::getWidgetColumns();
    }

    protected function getTableFilters(): array
    {
        return [

        ];
    }

    protected function getTableRecordUrlUsing(): \Closure
    {
        return fn (Organization $record) => OrganizationResource::getUrl('edit', [
            'record' => $record,
        ]);
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('view')
                ->label(__('organization.actions.view'))
                ->url(fn (Organization $record) => OrganizationResource::getUrl('view', [
                    'record' => $record,
                ]))
                ->icon(null),
            Action::make('edit')
                ->label(__('organization.actions.edit'))
                ->url(self::getTableRecordUrlUsing())
                ->size('sm')
                ->icon(null),
            Action::make('reject')
                ->label(__('organization.actions.reject'))
                ->action(fn (Organization $record) => $record->status = OrganizationStatus::rejected->value)
                ->size('sm')
                ->icon(null),

            ];
    }
}
