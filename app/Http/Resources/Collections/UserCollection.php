<?php

declare(strict_types=1);

namespace App\Http\Resources\Collections;

use App\Http\Resources\Columns\TableColumn;
use App\Http\Resources\UserResource;

class UserCollection extends ResourceCollection
{
    public $collects = UserResource::class;

    protected function getColumns(): array
    {
        return [
            TableColumn::make('name')
                ->label(__('user.column.name'))
                ->sortable(),

            TableColumn::make('email')
                ->label(__('user.column.email')),

            TableColumn::make('role')
                ->label(__('user.column.role')),
        ];
    }
}
