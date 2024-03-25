<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Widgets;

use App\Models\Organization;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class OrganizationsTops extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Organization::query()
            ->with('counties')
            ->withSum('donations', 'amount')
            ->withCount([
                'volunteers',
                'donations',
            ])
            ->isApproved();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label(__('organization.labels.name'))
                ->sortable()
                ->searchable(),

            TextColumn::make('activity_domains')
                ->label(__('organization.labels.activity_domains'))
                ->sortable(),

            TextColumn::make('counties')
                ->label(__('organization.labels.county'))
                ->formatStateUsing(fn (Collection $state) => $state->pluck('name')->implode(', ')),

            TextColumn::make('donations_sum_amount')
                ->label(__('organization.labels.donations_amount'))
                ->sortable(),

            TextColumn::make('donations_count')
                ->label(__('organization.labels.donations_count'))
                ->sortable(),

            TextColumn::make('volunteers_count')
                ->label(__('organization.labels.volunteers_count'))
                ->sortable(),

        ];
    }
}
