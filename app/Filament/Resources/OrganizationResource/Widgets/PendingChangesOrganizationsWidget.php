<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Widgets;

use App\Tables\Columns\TitleWithImageColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class PendingChangesOrganizationsWidget extends BaseOrganizationsWidget
{
    protected function getTableHeading(): string
    {
        return __('organization.heading.pending_changes');
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->whereHas('activities', function ($q) {
            $q->where('log_name', 'pending')
                ->where('approved_at', null)
                ->where('rejected_at', null);
        });
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'pending_changes';
    }

    protected function getTableColumns(): array
    {
        return [
            TitleWithImageColumn::make('name')
                ->label(__('organization.organization'))
                ->image(fn ($record) => $record->cover_image)
                ->description(
                    fn ($record) => sprintf(
                        '%s: %s',
                        __('field.updated_at'),
                        $record->activities->last()->created_at->toFormattedDateTime()
                    )
                )
                ->searchable()
                ->sortable(),

            TextColumn::make('created_at')
                ->label(__('organization.labels.approved_at'))
                ->description(
                    fn ($record) => sprintf(
                        '%s: %s',
                        __('field.updated_at'),
                        $record->activities->last()->created_at->toFormattedDateTime()
                    )
                )
                ->dateTime()
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make()
                ->label(__('organization.actions.view'))
                ->url($this->getTableRecordUrlUsing()),
        ];
    }
}
