<?php

declare(strict_types=1);

namespace App\Filament\Resources\EditionsResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class FaqRelationManager extends RelationManager
{
    protected static string $relationship = 'faqs';

    protected static ?string $recordTitleAttribute = 'Faq';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('question')
                    ->required()
                    ->maxLength(255)
                    ->label(__('edition.labels.question')),

                Forms\Components\Textarea::make('answer')
                    ->required()
                    ->label(__('edition.labels.answer')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label(__('edition.labels.question'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('answer')
                    ->label(__('edition.labels.answer'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('edition.labels.add_faq')),
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
        return __('edition.labels.faq_tab');
    }
}
