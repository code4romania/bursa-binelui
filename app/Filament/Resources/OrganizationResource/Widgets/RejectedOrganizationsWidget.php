<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Widgets;

use App\Filament\Resources\OrganizationResource;
use App\Filament\Resources\OrganizationResource\Actions\Tables\Organizations\ReactivateOrganizationAction;
use App\Models\Organization;
use App\Tables\Columns\TitleWithImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
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

            ReactivateOrganizationAction::make(),
        ];
    }

    protected function getTableFilters(): array
    {
        $statusUpdateFilter = [
            Filter::make('status_updated_at')
                ->columns()
                ->form([
                    DatePicker::make('status_updated_from')
                        ->label(__('activity.filter.logged_from'))
                        ->placeholder(
                            fn ($state): string => today()
                                ->setDay(17)
                                ->setMonth(11)
                                ->subYear()
                                ->toFormattedDate()
                        ),

                    DatePicker::make('status_updated_until')
                        ->label(__('activity.filter.logged_until'))
                        ->after('status_updated_from')
                        ->placeholder(
                            fn ($state): string => today()
                                ->toFormattedDate()
                        ),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query
                        ->when(
                            $data['status_updated_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('status_updated_at', '>=', $date),
                        )
                        ->when(
                            $data['status_updated_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('status_updated_at', '<=', $date),
                        );
                })
        ];

        return array_merge($statusUpdateFilter, parent::getTableFilters());
    }
}
