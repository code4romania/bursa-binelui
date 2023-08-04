<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\OrganizationStatus;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Filament\Resources\OrganizationResource\Widgets\ApprovedOrganizationWidget;
use App\Filament\Resources\OrganizationResource\Widgets\NewOrganizationWidget;
use App\Filament\Resources\OrganizationResource\Widgets\RejectedOrganizationWidget;
use App\Forms\Components\Link;
use App\Forms\Components\UserLink;
use App\Models\Organization;
use App\Tables\Columns\OrganizationNameColumn;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
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
                UserLink::make('administator')->label(__('organization.labels.administrator'))->inlineLabel()->columnSpanFull(),
                Forms\Components\Fieldset::make(__('organization.labels.general_data'))->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('organization.labels.name'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('cif')
                        ->label(__('organization.labels.cif'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('organizationFilesLogo')
                        ->collection('organizationFilesLogo')
                        ->label(__('organization.labels.logo'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->required()
                        ->maxFiles(1)
                        ->acceptedFileTypes(['image/*']),
                    Forms\Components\Textarea::make('description')
                        ->label(__('organization.labels.description'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->required()
                        ->maxLength(65535),
                    Forms\Components\Select::make('activity_domains')
                        ->label(__('organization.labels.activity_domains'))
                        ->columnSpanFull()
                        ->inlineLabel()
                        ->multiple()
                        ->relationship('activityDomains', 'name')
                        ->required(),
                    Forms\Components\Grid::make(3)
                        ->schema(
                            [
                                Link::make('organizationFilesStatuteLabel')->inlineLabel()->label(__('organization.labels.statute')),
                                Forms\Components\SpatieMediaLibraryFileUpload::make('organizationFilesStatute')
                                    ->disableLabel()
                                    ->disablePreview()
                                ->collection('organizationFilesStatute')
                                ->required()
                            ]
                        )->columns(2),
                ]),
                Forms\Components\Fieldset::make(__('organization.labels.volunteering_data'))->schema([
                    Forms\Components\Toggle::make('accepts_volunteers')
                        ->label(__('organization.labels.accepts_volunteers'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\Textarea::make('why_volunteer')
                        ->label(__('organization.labels.why_volunteer'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->maxLength(65535),

                ]),
                Forms\Components\Fieldset::make(__('organization.labels.contact_data'))->schema([
                    Forms\Components\TextInput::make('website')
                        ->label(__('organization.labels.website'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('contact_email')
                        ->email()
                        ->label(__('organization.labels.contact_email'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('contact_phone')
                        ->tel()
                        ->label(__('organization.labels.contact_phone'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('contact_person')
                        ->label(__('organization.labels.contact_person'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('street_address')
                        ->label(__('organization.labels.street_address'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->required()
                        ->maxLength(255),
                ]),
                Forms\Components\Fieldset::make(__('organization.labels.eu_platesc_data'))->schema([
                    Forms\Components\TextInput::make('eu_platesc_merchant_id')
                        ->label(__('organization.labels.eu_platesc_merchant_id'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('eu_platesc_private_key')
                        ->label(__('organization.labels.eu_platesc_private_key'))
                        ->inlineLabel()
                        ->columnSpanFull()
                        ->maxLength(255),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('status')->options([
                    'heroicon-o-x-circle',
                    'heroicon-o-pencil' => OrganizationStatus::rejected->value,
                    'heroicon-o-clock' => OrganizationStatus::pending->value,
                    'heroicon-o-check-circle' => OrganizationStatus::approved->value,
                ]),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(OrganizationStatus::options())
                    ->label(__('Status organizație')),
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

    public static function getWidgets(): array
    {
        return [
            NewOrganizationWidget::class,
            ApprovedOrganizationWidget::class,
            RejectedOrganizationWidget::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\OrganisationIndex::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }

    public static function getWidgetColumns()
    {
        return [
            OrganizationNameColumn::make('organisation_info')->label(__('organization.organization')),

            TextColumn::make('created_at')
                ->label(__('field.created_at'))
                ->dateTime('Y-m-d')
                ->sortable(),

        ];
    }
}
