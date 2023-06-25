<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ChampionshipResource\Pages;
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

class ChampionshipResource extends Resource
{
    protected static ?string $model = Championship::class;

    protected static ?string $navigationGroup = 'Campionatul de bine';

    protected static ?int $navigationSort = 12;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $label = 'Listă ediți';

    protected static ?string $pluralLabel = 'Listă ediții';

    protected static ?string $navigationLabel = 'Ediții anterioare';

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
                Tables\Columns\TextColumn::make('name')->label('Denumire ediție'),
                //                Tables\Columns\TextColumn::make('description'),

                Tables\Columns\TextColumn::make('start_date')->label('Dată început')
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')->label('Dată final')
                    ->date(),
                //
                //                Tables\Columns\IconColumn::make('is_current')
                //                    ->boolean(),
                //                Tables\Columns\IconColumn::make('needs_approval')
                //                    ->boolean(),
                //                Tables\Columns\TextColumn::make('created_at')
                //                    ->dateTime(),
                //                Tables\Columns\TextColumn::make('updated_at')
                //                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editează'),
                Tables\Actions\ViewAction::make()->label('Vizualizează'),
                //TODO Custome actions for stages, projects, testimonials, articles

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
            ArticlesRelationManager::class,
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
