<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\OrganizationStatus;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Models\Organization;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationGroup = 'Administrează';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Organizații';
    protected static ?string $label = 'Organizație';
    protected static ?string $pluralLabel = 'Organizații';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('county_id')
                    ->relationship('counties', 'name')
                    ->multiple()
                    ->required(),
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
                Forms\Components\Select::make('activity_domains')
                    ->multiple()
                    ->relationship('activityDomains', 'name')
                    ->required(),
                Forms\Components\Textarea::make('why_volunteer')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\Toggle::make('accepts_volunteers')
                    ->required(),
                Forms\Components\TextInput::make('eu_platesc_merchant_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('eu_platesc_private_key')
                    ->required()
                    ->maxLength(255),
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
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(OrganizationStatus::options())
                    ->label(__('Status organizație'))
            ])
            ->filtersLayout(Layout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make(__('organization.actions.approve'))
                    ->action(function () {
                    })
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation(),
                Tables\Actions\Action::make(__('organization.actions.reject'))
                    ->action(function () {
                    })
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation(),
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
