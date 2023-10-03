<?php

declare(strict_types=1);

namespace App\Http\Resources\Collections;

use App\Http\Resources\Columns\TableColumn;
use App\Http\Resources\DonationResource;

class DonationCollection extends ResourceCollection
{
    public $collects = DonationResource::class;

    protected function getColumns(): array
    {
        return [
            TableColumn::make('created_at')
                ->label(__('donation.column.created_at'))
                ->sortable(),

            TableColumn::make('donor')
                ->label(__('donation.column.donor')),

            TableColumn::make('project')
                ->label(__('donation.column.project')),

            TableColumn::make('amount')
                ->label(__('donation.column.amount'))
                ->sortable(),

            TableColumn::make('status')
                ->label(__('donation.column.status'))
                ->sortable(),
        ];
    }
}
