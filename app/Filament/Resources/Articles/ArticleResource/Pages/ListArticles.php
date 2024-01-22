<?php

declare(strict_types=1);

namespace App\Filament\Resources\Articles\ArticleResource\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use App\Models\Article;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

class ListArticles extends ListRecords
{
    use Translatable;

    protected static string $resource = ArticleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableHeading(): string
    {
        return __('article.header.article', ['number' => Article::count()]) ;
    }
}
