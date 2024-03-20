<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class UsersTops extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return User::query()
            ->withSum('donations', 'amount')
            ->withCount(['donations', 'badges', 'volunteer']);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label(__('user.name'))
                ->searchable()
                ->sortable(),

            TextColumn::make('email')
                ->label(__('user.email'))
                ->searchable()
                ->sortable(),

            TextColumn::make('donations_sum_amount')
                ->label(__('user.labels.donations_sum'))
                ->sortable(),

            TextColumn::make('donations_count')
                ->label(__('user.labels.donations_count'))
                ->sortable(),

            TextColumn::make('badges_count')
                ->label(__('user.labels.badges_count'))
                ->sortable(),

            TextColumn::make('volunteer_count')
                ->label(__('user.labels.volunteer_count'))
                ->sortable(),
        ];
    }
}
