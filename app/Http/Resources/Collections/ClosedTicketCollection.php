<?php

declare(strict_types=1);

namespace App\Http\Resources\Collections;

use App\Http\Resources\Columns\TableColumn;
use App\Http\Resources\TicketResource;

class ClosedTicketCollection extends ResourceCollection
{
    public $collects = TicketResource::class;

    protected function getColumns(): array
    {
        return [
            TableColumn::make('id')
                ->label(__('ticket.column.id'))
                ->sortable(),

            TableColumn::make('subject')
                ->label(__('ticket.column.subject')),

            TableColumn::make('closed_at')
                ->label(__('ticket.column.closed_at'))
                ->sortable(),
        ];
    }
}
