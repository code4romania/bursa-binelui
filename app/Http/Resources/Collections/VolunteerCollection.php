<?php

declare(strict_types=1);

namespace App\Http\Resources\Collections;

use App\Http\Resources\Columns\TableColumn;
use App\Http\Resources\Volunteers\VolunteerResource;

class VolunteerCollection extends ResourceCollection
{
    public $collects = VolunteerResource::class;

    protected function getColumns(): array
    {
        return [
            TableColumn::make('name')
                ->label(__('volunteer.column.name'))
                ->sortable(),

            TableColumn::make('phone')
                ->label(__('volunteer.column.phone')),

            TableColumn::make('project')
                ->label(__('volunteer.column.project')),

            TableColumn::make('created_at')
                ->label(__('volunteer.column.created_at'))
                ->sortable(),

            TableColumn::make('has_user')
                ->label(__('volunteer.column.has_user')),
        ];
    }
}
