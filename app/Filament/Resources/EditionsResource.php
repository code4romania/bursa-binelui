<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\EditionsResource\Pages\CreateEditions;
use App\Filament\Resources\EditionsResource\Pages\EditEditions;
use App\Filament\Resources\EditionsResource\Pages\ListEditions;
use App\Filament\Resources\EditionsResource\RelationManagers\CategoryRelationManager;
use App\Filament\Resources\EditionsResource\RelationManagers\FaqRelationManager;
use App\Filament\Resources\EditionsResource\RelationManagers\GalesRelationManager;
use App\Filament\Resources\EditionsResource\RelationManagers\PrizesRelationManager;
use App\Models\ArticleCategory;
use App\Models\Edition;
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
        return __('navigation.group.gala');
    }

    public static function getModelLabel(): string
    {
        return __('edition.label.singular');
    }

    public static function getPluralLabel(): string
    {
        return __('edition.label.plural');
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
                            ->relationship('page', 'title')
                            ->label(__('edition.labels.rule_page'))
                            ->preload()
                            ->required(),

                        Select::make('article_category_id')
                            ->relationship('article_category', 'name')
                            ->options(ArticleCategory::all()
                                ->pluck('name', 'id'))
                            ->label(__('edition.labels.edition_category'))
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
            'index' => ListEditions::route('/'),
            'create' => CreateEditions::route('/create'),
            'edit' => EditEditions::route('/{record}/edit'),
        ];
    }
}
