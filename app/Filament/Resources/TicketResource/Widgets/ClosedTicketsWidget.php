<?php

declare(strict_types=1);

namespace App\Filament\Resources\TicketResource\Widgets;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Closure;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Widgets\TableWidget;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class ClosedTicketsWidget extends TableWidget
{
    protected static ?string $heading = 'Tichete închise';

    protected function getTableQuery(): Builder
    {
        return Ticket::query()
            ->whereClosed()
            ->with([
                'organization' => function (Relation $query) {
                    $query->withoutEagerLoads();
                },
            ]);
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'closed';
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'closed_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('subject')
                ->label(__('ticket.subject')),
            TextColumn::make('organization.name')
                ->label(__('ticket.organization')),
            TextColumn::make('closed_at')
                ->label(__('ticket.closed_at')),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make()
                ->url($this->getTableRecordUrlUsing()),
        ];
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Ticket $record) => TicketResource::getUrl('view', $record);
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->simplePaginate(
            $this->getTableRecordsPerPage() == -1 ? $query->count() : $this->getTableRecordsPerPage(),
            ['*'],
            $this->getTablePaginationPageName()
        );
    }

    protected function getTableFilters(): array
    {
        return [Filter::make('updated_at')
            ->columns()
            ->form([
                DatePicker::make('updated_from')
                    ->label(__('activity.filter.logged_from'))
                    ->placeholder(
                        fn ($state): string => today()
                            ->setDay(17)
                            ->setMonth(11)
                            ->subYear()
                            ->toFormattedDate()
                    ),

                DatePicker::make('updated_until')
                    ->label(__('activity.filter.logged_until'))
                    ->after('updated_from')
                    ->placeholder(
                        fn ($state): string => today()
                            ->toFormattedDate()
                    ),
            ])
            ->query(function (Builder $query, array $data) {
                return $query
                    ->when(
                        $data['updated_from'],
                        fn (Builder $query, $date): Builder => $query->whereDate('updated_at', '>=', $date),
                    )
                    ->when(
                        $data['updated_until'],
                        fn (Builder $query, $date): Builder => $query->whereDate('updated_at', '<=', $date),
                    );
            })];
    }
}
