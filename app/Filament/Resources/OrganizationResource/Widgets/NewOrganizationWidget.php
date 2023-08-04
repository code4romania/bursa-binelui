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

class NewOrganizationWidget extends BaseWidget
{
    use CanPaginateRecords {
        paginateTableQuery as protected;
    }

    protected static ?int $sort = 1;

    /** @var string */
    protected static string $resource = OrganizationResource::class;

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
        return __('organization.heading.in_approval');
    }

    protected function getTableQuery(): Builder
    {
        return Organization::query()->isPending();
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'new_organization';
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
            Action::make('edit')
                ->label(__('organization.actions.edit'))
                ->url(self::getTableRecordUrlUsing())
                ->size('sm')
                ->icon(null),
            Action::make('accept')
                ->label(__('organization.actions.approve'))
                ->size('sm')
                ->icon(null)
                ->action(fn (Organization $record) => $record->status = OrganizationStatus::approved->value)
                ->requiresConfirmation(),
            Action::make('reject')
                ->label(__('organization.actions.reject'))
                ->action(fn (Organization $record) => $record->status = OrganizationStatus::rejected->value)
                ->size('sm')
                ->icon(null),
        ];
    }
}
