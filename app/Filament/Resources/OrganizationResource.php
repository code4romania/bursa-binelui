<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Forms\Components\Download;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Forms\Components\UserLink;
use App\Models\Organization;
use App\Rules\ValidCIF;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-office-building';

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.manage');
    }

    public static function getModelLabel(): string
    {
        return __('organization.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('organization.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                UserLink::make('administator')
                    ->label(__('organization.labels.administrator'))
                    ->inlineLabel()
                    ->columnSpanFull(),

                Fieldset::make(__('organization.labels.general_data'))
                    ->columns(1)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('organization.labels.name'))
                            ->inlineLabel()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('cif')
                            ->label(__('organization.labels.cif'))
                            ->unique(ignoreRecord: true)
                            ->rule(new ValidCIF)
                            ->inlineLabel()
                            ->required()
                            ->maxLength(255),

                        SpatieMediaLibraryFileUpload::make('organizationFilesLogo')
                            ->collection('organizationFilesLogo')
                            ->label(__('organization.labels.logo'))
                            ->inlineLabel()
                            ->image()
                            ->maxFiles(1),

                        Textarea::make('description')
                            ->label(__('organization.labels.description'))
                            ->inlineLabel()
                            ->required()
                            ->maxLength(65535),

                        Select::make('activity_domains')
                            ->relationship('activityDomains', 'name')
                            ->label(__('organization.labels.activity_domains'))
                            ->inlineLabel()
                            ->multiple()
                            ->preload()
                            ->required(),

                        Select::make('counties')
                            ->relationship('counties', 'name')
                            ->label(__('organization.labels.counties'))
                            ->inlineLabel()
                            ->multiple()
                            ->preload()
                            ->required(),

                        SpatieMediaLibraryFileUpload::make('organizationFilesStatute')
                            ->label(__('organization.labels.statute'))
                            ->inlineLabel()
                            ->disablePreview()
                            ->collection('organizationFilesStatute')
                            ->hiddenOn('view'),

                        Download::make('organizationFilesStatute')
                            ->label(__('organization.labels.statute'))
                            ->inlineLabel()
                            ->hiddenOn('edit'),
                    ]),

                Fieldset::make(__('organization.labels.volunteering_data'))
                    ->columns(1)
                    ->schema([
                        Toggle::make('accepts_volunteers')
                            ->label(__('organization.labels.accepts_volunteers'))
                            ->inlineLabel()
                            ->required(),

                        Textarea::make('why_volunteer')
                            ->label(__('organization.labels.why_volunteer'))
                            ->inlineLabel()
                            ->maxLength(65535),
                    ]),

                Fieldset::make(__('organization.labels.contact_data'))
                    ->columns(1)
                    ->schema([
                        TextInput::make('website')
                            ->label(__('organization.labels.website'))
                            ->inlineLabel()
                            ->maxLength(255),

                        TextInput::make('contact_email')
                            ->label(__('organization.labels.contact_email'))
                            ->email()
                            ->inlineLabel()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('contact_phone')
                            ->tel()
                            ->label(__('organization.labels.contact_phone'))
                            ->inlineLabel()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('contact_person')
                            ->label(__('organization.labels.contact_person'))
                            ->inlineLabel()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('street_address')
                            ->label(__('organization.labels.street_address'))
                            ->inlineLabel()
                            ->required()
                            ->maxLength(255),
                    ]),

                Fieldset::make(__('organization.labels.eu_platesc_data'))
                    ->columns(1)
                    ->schema([
                        TextInput::make('eu_platesc_merchant_id')
                            ->label(__('organization.labels.eu_platesc_merchant_id'))
                            ->inlineLabel()
                            ->maxLength(255),

                        TextInput::make('eu_platesc_private_key')
                            ->label(__('organization.labels.eu_platesc_private_key'))
                            ->inlineLabel()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
            'view' => Pages\ViewOrganization::route('/{record}'),
        ];
    }
}
