<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BadgeResource\Pages;
use App\Filament\Resources\BadgeResource\RelationManagers\UsersRelationManager;
use App\Models\Badge;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class BadgeResource extends Resource
{
    protected static ?string $model = Badge::class;

    protected static ?string $navigationGroup = 'Administrează';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-badge-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('badge.title'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->maxLength(200)
                    ->required(),

                Textarea::make('description')
                    ->label(__('badge.description'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('image')
                    ->label(__('badge.image'))
                    ->inlineLabel()
                    ->required()
                    ->maxFiles(1)
                    ->image()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->square(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('users_count')
                    ->counts('users')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBadges::route('/'),
            'create' => Pages\CreateBadge::route('/create'),
            'view' => Pages\ViewBadge::route('/{record}'),
            'edit' => Pages\EditBadge::route('/{record}/edit'),
        ];
    }
}
