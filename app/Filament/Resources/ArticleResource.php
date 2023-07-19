<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationGroup = 'Administrează';

    protected static ?string $navigationLabel = 'Articole';

    protected static ?string $label = 'Articol';

    protected static ?string $pluralLabel = 'Articole';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->label(__('article.title'))
                    ->required()
                    ->maxLength(255),
                Select::make('article_category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->label(__('article.category')),
                RichEditor::make('content')
                    ->required()
                    ->label(__('article.content'))->columnSpanFull(),
                TextInput::make('author')
                    ->required()
                    ->label(__('article.author'))
                    ->required()
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->label(__('article.is_active'))
                    ->required(),
                SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('cover')
                    ->label(__('article.cover_image'))
                    ->required()
                    ->acceptedFileTypes(['image/*'])
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('gallery')->collection('gallery')
                    ->multiple()
                    ->label(__('article.gallery'))
                    ->enableReordering()->columnSpanFull(),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->label(__('article.title'))->searchable(),
                Tables\Columns\TextColumn::make('category.name')->searchable()->label(__('article.category'))->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('article.created_at'))->sortable(),

            ])
            ->filters([
                SelectFilter::make('category')
                    ->multiple()
                    ->relationship('category', 'name')
                    ->label(__('article.filter.category')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->filtersLayout(Layout::AboveContent)
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
