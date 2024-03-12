<?php

declare(strict_types=1);

namespace App\Filament\Resources\EditionsResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class GalesRelationManager extends RelationManager
{
    protected static string $relationship = 'gales';

    protected static ?string $recordTitleAttribute = 'Gales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label(__('edition.labels.title_gale')),

                SpatieMediaLibraryFileUpload::make('image')
                    ->label(__('edition.labels.add_gala_picture'))
                    ->disk(config('filesystems.default_public'))
                    ->collection('preview')
                    ->required()
                    ->maxFiles(1)
                    ->image()
                    ->columnSpanFull(),

                Forms\Components\Grid::make()
                    ->schema([
                        DatePicker::make('start_date')
                            ->label(__('edition.labels.start_interval'))
                            ->placeholder(
                                fn ($state): string => today()
                                    ->toFormattedDate()
                            )
                            ->required(),

                        DatePicker::make('end_date')
                            ->label(__('edition.labels.end_interval'))
                            ->placeholder(
                                fn ($state): string => today()
                                    ->toFormattedDate()
                            )
                            ->required(),
                    ]),

                Select::make('counties')
                    ->relationship('counties', 'name')
                    ->label(__('edition.labels.counties'))
                    ->columnSpanFull()
                    ->multiple()
                    ->required()
                    ->preload(),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Fieldset::make(__('edition.labels.sign_up_interval'))->schema([
                            DatePicker::make('start_sign_up')
                                ->label(__('edition.labels.start_interval'))
                                ->placeholder(
                                    fn ($state): string => today()
                                        ->toFormattedDate()
                                )
                                ->required(),

                            DatePicker::make('end_sign_up')
                                ->label(__('edition.labels.end_interval'))
                                ->placeholder(
                                    fn ($state): string => today()
                                        ->toFormattedDate()
                                )
                                ->required(),
                        ]),
                    ]),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Fieldset::make(__('edition.labels.validation_interval'))->schema([
                            DatePicker::make('start_validate')
                                ->label(__('edition.labels.start_interval'))
                                ->placeholder(
                                    fn ($state): string => today()
                                        ->toFormattedDate()
                                )
                                ->required(),

                            DatePicker::make('end_validate')
                                ->label(__('edition.labels.end_interval'))
                                ->placeholder(
                                    fn ($state): string => today()
                                        ->toFormattedDate()
                                )
                                ->required(),
                        ]),
                    ]),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Fieldset::make(__('edition.labels.evaluation_interval'))->schema([
                            DatePicker::make('start_evaluation')
                                ->label(__('edition.labels.start_interval'))
                                ->placeholder(
                                    fn ($state): string => today()
                                        ->toFormattedDate()
                                )
                                ->required(),

                            DatePicker::make('end_evaluation')
                                ->label(__('edition.labels.end_interval'))
                                ->placeholder(
                                    fn ($state): string => today()
                                        ->toFormattedDate()
                                )
                                ->required(),
                        ]),
                    ]),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Fieldset::make(__('edition.labels.gale_date'))->schema([
                            DateTimePicker::make('start_gale')
                                ->label(__('edition.labels.gale_datetime'))
                                ->placeholder(
                                    fn ($state): string => today()
                                        ->toFormattedDate()
                                )
                                ->required(),
                        ]),
                    ]),

                Forms\Components\TextInput::make('location')
                    ->label(__('edition.labels.location')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('edition.labels.title_gale'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('edition.labels.start_interval'))
                    ->searchable()
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label(__('edition.labels.end_interval'))
                    ->searchable()
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('edition.labels.add_gale')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getTitle(): string
    {
        return __('edition.labels.gales_tab');
    }
}
