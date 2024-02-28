<?php

declare(strict_types=1);

namespace App\Filament\Resources\EditionsResource\RelationManagers;

use App\Models\EditionCategories;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class PrizesRelationManager extends RelationManager
{
    protected static string $relationship = 'prize';

    protected static ?string $recordTitleAttribute = 'Prize';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('edition.labels.prize_name')),

                Forms\Components\Select::make('edition_categories_id')
                    ->options(
                        fn (RelationManager $livewire) => EditionCategories::query()
                            ->whereBelongsTo($livewire->ownerRecord)
                            ->get()
                            ->pluck('name', 'id')
                    )
                    ->label(__('edition.labels.category'))
                    ->columnSpanFull()
                    ->required()
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

                Tables\Columns\TextColumn::make('edition_categories_id')
                    ->label(__('edition.labels.category'))
                    ->formatStateUsing(
                        fn ($state, $record) => $record->editionCategories()->getParent()->name
                    )
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
