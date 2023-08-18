<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Widgets;

use App\Filament\Resources\OrganizationResource;
use App\Filament\Resources\OrganizationResource\Actions\RejectAction;
use App\Models\Organization;
use Filament\Tables\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ApprovedOrganizationWidget extends BaseWidget
{
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
        return Organization::isApproved()
            ->with(['media'])
            ->select(['id', 'name', 'created_at', 'status']);
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
        return fn (Organization $record) => OrganizationResource::getUrl('view', $record);
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('view')
                ->label(__('organization.actions.view'))
                ->url($this->getTableRecordUrlUsing())
                ->icon(null),

            Action::make('edit')
                ->label(__('organization.actions.edit'))
                ->url(fn (Organization $record) => OrganizationResource::getUrl('edit', $record))
                ->icon(null),

            RejectAction::make('reject'),
        ];
    }
}
