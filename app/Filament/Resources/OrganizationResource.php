<?php

namespace App\Filament\Resources;

use App\Enums\OrganizationStatus;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Filament\Resources\OrganizationResource\RelationManagers;
use App\Models\Organization;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('county_id')
                    ->relationship('county', 'name')
                    ->required(),
//                Forms\Components\Select::make('city_id')
//                    ->relationship('city', 'name')
//                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cif')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status_document')
                    ->maxLength(255),
                Forms\Components\TextInput::make('street_address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_person')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('website')
                    ->maxLength(255),
                Forms\Components\TextInput::make('activity_domains')
                    ->required(),
                Forms\Components\Textarea::make('why_volunteer')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\Toggle::make('accepts_volunteers')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('status')->options([
                    'heroicon-o-x-circle',
                    'heroicon-o-pencil' => OrganizationStatus::disabled->value,
                    'heroicon-o-clock' => OrganizationStatus::pending->value,
                    'heroicon-o-check-circle' => OrganizationStatus::active->value,
                ]),
                Tables\Columns\TextColumn::make('county.name'),
                Tables\Columns\TextColumn::make('city.name'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('cif'),
                Tables\Columns\TextColumn::make('street_address'),
                Tables\Columns\TextColumn::make('contact_person'),
                Tables\Columns\TextColumn::make('contact_phone'),
                Tables\Columns\TextColumn::make('contact_email'),
                Tables\Columns\TextColumn::make('website'),
                Tables\Columns\IconColumn::make('accepts_volunteers')
                    ->boolean(),

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
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}
