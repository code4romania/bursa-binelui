<?php

namespace App\Filament\Resources;

use App\Enums\ProjectStatus;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                Forms\Components\Select::make('status')->options(ProjectStatus::options())->disabled()
                    ->required(),
                Forms\Components\Toggle::make('is_national')
                    ->required(),
                Forms\Components\Select::make('county_id')
                    ->relationship('county', 'name'),
                Forms\Components\TextInput::make('category')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('target_budget')
                    ->required(),
                Forms\Components\DatePicker::make('start')
                    ->required(),
                Forms\Components\DatePicker::make('end')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('scope')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('beneficiaries')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('reason_to_donate')
                    ->maxLength(65535),
                Forms\Components\Toggle::make('accepting_volunteers')
                    ->required(),
                Forms\Components\Toggle::make('accepting_comments')
                    ->required(),
                Forms\Components\TextInput::make('videos'),
                Forms\Components\TextInput::make('external_links'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('organization.name'),
                Tables\Columns\TextColumn::make('county.name'),
                Tables\Columns\IconColumn::make('status')->options([
                    'heroicon-o-x-circle',
                    'heroicon-o-pencil' => ProjectStatus::draft->value,
                    'heroicon-o-clock' => ProjectStatus::disabled->value,
                    'heroicon-o-check-circle' => ProjectStatus::active->value,
                ]),
                Tables\Columns\TextColumn::make('category'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('start')
                    ->date(),
                Tables\Columns\TextColumn::make('end')
                    ->date(),
                Tables\Columns\IconColumn::make('accepting_volunteers')->label('Volunteers')
                    ->boolean(),
                Tables\Columns\IconColumn::make('accepting_comments')->label('Comments')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\ViewAction::make()->iconButton(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])->actionsPosition(Position::BeforeCells);

    }
    protected function getTableActionsPosition(): ?string
    {
        return Position::BeforeCells;
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
            'index' => Pages\ListProjects::route('/'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
