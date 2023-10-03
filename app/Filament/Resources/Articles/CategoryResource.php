<?php

declare(strict_types=1);

namespace App\Filament\Resources\Articles;

use App\Filament\Resources\Articles\CategoryResource\Pages;
use App\Models\ArticleCategory;
use Camya\Filament\Forms\Components\TitleWithSlugInput;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class CategoryResource extends Resource
{
    use Translatable;

    protected static ?string $model = ArticleCategory::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $slug = 'articles/categories';

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.articles');
    }

    public static function getModelLabel(): string
    {
        return __('article.category.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('article.category.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TitleWithSlugInput::make(
                    fieldTitle: 'name',
                    fieldSlug: 'slug',
                    urlPath: '/articles/category/',
                    urlVisitLinkRoute: fn (?ArticleCategory $record) => $record?->slug
                        ? route('articles.category', $record)
                        : null,
                )->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('article.title'))
                    ->sortable(),

                TextColumn::make('articles_count')
                    ->label(__('article.category.articles_count'))
                    ->counts('articles')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label(__('article.updated_at'))
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
