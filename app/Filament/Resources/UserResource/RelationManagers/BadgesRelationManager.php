<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class BadgesRelationManager extends RelationManager
{
    protected static string $relationship = 'badges';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getTitle(): string
    {
        return __('user.relations.badges');
    }

    protected function getTableHeading(): string
    {
        return __('user.relations.heading.badges', ['count' => $this->getTableQuery()->count()]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label(__('badge.image'))
                    ->square(),

                TextColumn::make('title')
                    ->label(__('badge.title'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label(__('badge.action.attach'))
                    ->modalHeading(__('badge.action.attach'))
                    ->color('primary'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->label(__('badge.action.detach')),
            ])
            ->bulkActions([
            ]);
    }
}
