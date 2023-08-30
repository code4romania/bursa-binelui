<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Widgets;

use App\Filament\Resources\OrganizationResource\Actions\Tables\Activity\ViewAction;
use App\Filament\Resources\UserResource;
use App\Models\Activity;
use App\Models\Organization;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class OrganizationActivityWidget extends BaseWidget
{
    public Organization $record;

    protected int | string | array $columnSpan = 2;

    protected function getTableQuery(): Builder
    {
        return Activity::query()
            ->forSubject($this->record)
            ->forEvent('updated');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('created_at')
                ->label(__('activity.column.created_at')),

            TextColumn::make('changed_field')
                ->label(__('activity.column.changed_field'))
                ->formatStateUsing(
                    fn ($state) => __('organization.labels.' . $state)
                ),

            TextColumn::make('causer.name')
                ->label(__('activity.column.causer'))
                ->description(
                    fn (Activity $record) => $record->causer?->role->label()
                )
                ->url(
                    fn (Activity $record) => $record->causer
                        ? UserResource::getUrl('view', $record->causer)
                        : null
                ),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
