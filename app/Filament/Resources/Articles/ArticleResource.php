<?php

declare(strict_types=1);

namespace App\Filament\Resources\Articles;

use App\Filament\Forms\Components\Value;
use App\Filament\Resources\Articles\ArticleResource\Pages;
use App\Models\Article;
use Camya\Filament\Forms\Components\TitleWithSlugInput;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;
use FilamentTiptapEditor\TiptapEditor;

class ArticleResource extends Resource
{
    use Translatable;

    protected static ?string $model = Article::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $slug = 'articles';

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.articles');
    }

    public static function getModelLabel(): string
    {
        return __('article.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('article.label.plural');
    }
    protected static function getNavigationBadge(): ?string
    {
        return (string) Article::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 3,
                'lg' => null,
            ])
            ->schema([
                Group::make()
                    ->columnSpan(['lg' => fn (?Article $record) => $record === null ? 3 : 2])
                    ->schema([
                        Card::make()
                            ->columns(2)
                            ->schema([
                                TitleWithSlugInput::make(
                                    fieldTitle: 'title',
                                    fieldSlug: 'slug',
                                    urlPath: '/articles/',
                                    urlVisitLinkRoute: fn (?Article $record) => $record?->slug
                                        ? route('articles.show', $record)
                                        : null,
                                )->columnSpanFull(),

                                TextInput::make('author')
                                    ->label(__('article.author'))
                                    ->required()
                                    ->required()
                                    ->maxLength(100),

                                Select::make('article_category_id')
                                    ->label(__('article.category.label.singular'))
                                    ->relationship('category', 'name')
                                    ->required(),

                                TiptapEditor::make('content')
                                    ->label(__('article.content'))
                                    ->extraInputAttributes([
                                        'style' => 'min-height: 12rem;',
                                    ])
                                    ->columnSpanFull()
                                    ->required(),
                            ]),

                        Card::make()
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('cover')
                                    ->label(__('article.cover_image'))
                                    ->collection('preview')
                                    ->required()
                                    ->image()
                                    ->maxFiles(1),
                            ]),

                        Card::make()
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('gallery')
                                    ->collection('gallery')
                                    ->label(__('article.gallery'))
                                    ->image()
                                    ->enableReordering()
                                    ->multiple()
                                    ->maxFiles(20),
                            ]),
                    ]),

                Card::make()
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Article $record) => $record === null)
                    ->schema([
                        Value::make('created_at')
                            ->label(__('article.created_at'))
                            ->withTime(),

                        Value::make('updated_at')
                            ->label(__('article.updated_at'))
                            ->withTime(),

                        Toggle::make('is_published')
                            ->label(__('article.is_published')),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->formatStateUsing(function (Article $record) {
                        return sprintf('#%d', $record->id);
                    })
                    ->label(__('volunteer.column.id'))
                    ->sortable(),
                TextColumn::make('title')
                    ->label(__('article.title'))
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label(__('article.category.label.singular'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('article.created_at'))
                    ->sortable(),

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
            ->defaultSort('id', 'desc')
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
