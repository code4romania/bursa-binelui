<?php

namespace App\Filament\Resources\Editions;

use App\Filament\Resources\Editions\EditionsResource\Pages;
use App\Filament\Resources\Editions\EditionsResource\RelationManagers\CategoryRelationManager;
use App\Filament\Resources\Editions\EditionsResource\RelationManagers\FaqRelationManager;
use App\Filament\Resources\Editions\EditionsResource\RelationManagers\GalesRelationManager;
use App\Filament\Resources\Editions\EditionsResource\RelationManagers\PrizesRelationManager;
use App\Models\ArticleCategory;
use App\Models\Edition;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class EditionsResource extends Resource
{
    protected static ?string $model = Edition::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.gale');
    }

    public static function getModelLabel(): string
    {
        return __('edition.label.singular');
    }

    public static function getEloquentQuery(): Builder
    {

        return parent::getEloquentQuery()->with(['edition_categories']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make(__('edition.label.singular'))
                    ->columns(1)
                    ->schema([
                        TextInput::make('title')
                            ->label(__('edition.labels.title'))
                            ->required()
                            ->maxLength(255),

                        Textarea::make('short_description')
                            ->label(__('edition.labels.short_description'))
                            ->required()
                            ->maxLength(65535),

                        SpatieMediaLibraryFileUpload::make('rule')
                            ->label(__('edition.labels.rule'))
                            ->disk(config('filesystems.default_public'))
                            ->required()
                            ->maxFiles(1)
                            ->columnSpanFull(),

                        Select::make('rule_page')
                            ->options(Page::all()
                                ->pluck('title', 'id'))
                            ->label(__('edition.labels.rule_page'))
                            ->multiple()
                            ->preload()
                            ->required(),

                        Select::make('edition_category')
                            ->options(ArticleCategory::all()
                                ->pluck('name', 'id'))
                            ->label(__('edition.labels.edition_category'))
                            ->multiple()
                            ->preload()
                            ->required(),

                        Forms\Components\Grid::make()
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label(__('edition.labels.start'))
                                    ->placeholder(
                                        fn ($state): string => today()
                                            ->toFormattedDate()
                                    ),

                                DatePicker::make('end_date')
                                    ->label(__('edition.labels.end'))
                                    ->placeholder(
                                        fn ($state): string => today()
                                            ->toFormattedDate()
                                    ),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('edition.labels.name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('categories')
                    ->label(__('edition.labels.categories'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('edition.labels.start_date'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label(__('edition.labels.end_date'))
                    ->searchable()
                    ->sortable(),
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
            CategoryRelationManager::class,
            FaqRelationManager::class,
            GalesRelationManager::class,
            PrizesRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEditions::route('/'),
            'create' => Pages\CreateEditions::route('/create'),
            'edit' => Pages\EditEditions::route('/{record}/edit'),
        ];
    }

}
