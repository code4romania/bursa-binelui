<?php

declare(strict_types=1);

namespace App\Filament\Resources\GalaProjectResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class PrizesRelationManager extends RelationManager
{
    protected static string $relationship = 'prizes';

    protected static ?string $recordTitleAttribute = 'name';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('edition.labels.prize_name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('editionCategories.name')
                    ->label(__('edition.labels.category'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(function (Builder $query, $livewire) {
                        $query->where('edition_id', $livewire->getOwnerRecord()->gala->edition_id);
                    }),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ]);
    }
}
