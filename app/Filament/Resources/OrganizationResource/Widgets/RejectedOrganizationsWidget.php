<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Widgets;

use App\Filament\Filters\DateFilter;
use App\Filament\Resources\OrganizationResource;
use App\Filament\Resources\OrganizationResource\Actions\Tables\Organizations\ReactivateOrganizationAction;
use App\Models\Organization;
use App\Tables\Columns\TitleWithImageColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class RejectedOrganizationsWidget extends BaseOrganizationsWidget
{
    protected $listeners = [
        'refreshRejectedOrganizationsWidget' => '$refresh',
    ];

    protected function getTableHeading(): string
    {
        return __('organization.heading.rejected', ['number' => $this->getTableQuery()->count()]);
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
            TextColumn::make('id')
                ->label(__('field.id'))
                ->formatStateUsing(
                    fn ($state) => __('field.id_format', ['number' => $state])
                )
                ->sortable(),

            TitleWithImageColumn::make('name')
                ->label(__('organization.organization'))
                ->image(fn ($record) => $record->getFirstMediaUrl('logo'))
                ->description(
                    fn ($record) => sprintf(
                        '%s: %s',
                        __('field.updated_at'),
                        $record->updated_at->toFormattedDateTime()
                    )
                )
                ->searchable()
                ->sortable(),

            TextColumn::make('updated_at')
                ->label(__('organization.labels.updated_at'))
                ->dateTime()
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
                ->iconButton()
                ->url($this->getTableRecordUrlUsing()),

            EditAction::make()
                ->label(__('organization.actions.edit'))
                ->iconButton()
                ->url(fn (Organization $record) => OrganizationResource::getUrl('edit', $record)),

            ReactivateOrganizationAction::make()
                ->iconButton(),
        ];
    }

    protected function getTableFilters(): array
    {
        return array_merge([DateFilter::make('status_updated_at')], parent::getTableFilters());
    }
}
