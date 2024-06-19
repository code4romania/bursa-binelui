<?php

declare(strict_types=1);

namespace App\Filament\Resources\EditionsResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class PrizesRelationManager extends RelationManager
{
    protected static string $relationship = 'prizes';

    protected static ?string $recordTitleAttribute = 'Prize';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('edition.labels.prize_name'))
                    ->maxLength(255)
                    ->required(),

                Forms\Components\Select::make('edition_categories_id')
                    ->label(__('edition.labels.category'))
                    ->relationship('editionCategories', 'name', function (Builder $query, self $livewire) {
                        $query->whereBelongsTo($livewire->ownerRecord);
                    })
                    ->searchable()
                    ->preload(),
            ]);
    }

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
                Tables\Actions\CreateAction::make()
                    ->label(__('edition.labels.add_prize')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getTitle(): string
    {
        return __('edition.labels.prizes_tab');
    }
}
