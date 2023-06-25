<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChampionshipResource\Pages;
use App\Filament\Resources\ChampionshipResource\RelationManagers;
use App\Filament\Resources\ChampionshipResource\RelationManagers\ArticlesRelationManager;
use App\Filament\Resources\ChampionshipResource\RelationManagers\ProjectsRelationManager;
use App\Filament\Resources\ChampionshipResource\RelationManagers\StagesRelationManager;
use App\Filament\Resources\ChampionshipResource\RelationManagers\TestimonialsRelationManager;
use App\Models\Championship;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChampionshipResource extends Resource
{
    protected static ?string $model = Championship::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)->columnSpanFull(),
                Forms\Components\DatePicker::make('registration_start_date')->after(now())->required(),
                Forms\Components\DatePicker::make('registration_end_date')->after('registration_start_date')->required(),
                Forms\Components\DatePicker::make('start_date')->after('registration_end_date')->required(),
                Forms\Components\DatePicker::make('end_date')->after('start_date')->required(),
                Forms\Components\Toggle::make('is_current')
                    ->nullable(),
                Forms\Components\Toggle::make('needs_approval')
                    ->nullable()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date(),
                Tables\Columns\TextColumn::make('registration_start_date')
                    ->date(),
                Tables\Columns\TextColumn::make('registration_end_date')
                    ->date(),
                Tables\Columns\IconColumn::make('is_current')
                    ->boolean(),
                Tables\Columns\IconColumn::make('needs_approval')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
            StagesRelationManager::class,
            ProjectsRelationManager::class,
            TestimonialsRelationManager::class,
            ArticlesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChampionships::route('/'),
            'create' => Pages\CreateChampionship::route('/create'),
            'edit' => Pages\EditChampionship::route('/{record}/edit'),
        ];
    }

}
