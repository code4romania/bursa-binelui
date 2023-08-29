<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Widgets;

use App\Filament\Resources\OrganizationResource;
use App\Filament\Resources\OrganizationResource\Actions\Tables\ReactivateAction;
use App\Models\Organization;
use App\Tables\Columns\TitleWithImageColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class RejectedOrganizationsWidget extends BaseOrganizationsWidget
{
    protected function getTableHeading(): string
    {
        return __('organization.heading.rejected');
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->isRejected();
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'rejected';
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
                        $record->updated_at->toFormattedDateTime()
                    )
                )
                ->searchable()
                ->sortable(),

            TextColumn::make('status_updated_at')
                ->label(__('organization.labels.rejected_at'))
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

            EditAction::make()
                ->label(__('organization.actions.edit'))
                ->url(fn (Organization $record) => OrganizationResource::getUrl('edit', $record)),

            ReactivateAction::make(),
        ];
    }
}
