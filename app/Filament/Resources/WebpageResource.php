<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\WebpageResource\Pages;
use App\Models\Webpage;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class WebpageResource extends Resource
{
    protected static ?string $model = Webpage::class;

    protected static ?string $navigationGroup = 'Administrează';

    protected static ?int $navigationSort = 8;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebpages::route('/'),
            'create' => Pages\CreateWebpage::route('/create'),
            'edit' => Pages\EditWebpage::route('/{record}/edit'),
        ];
    }
}
