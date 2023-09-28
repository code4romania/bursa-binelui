<?php

declare(strict_types=1);

namespace App\Filament\Resources\Articles\ArticleResource\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;

class EditArticle extends EditRecord
{
    use Translatable;

    protected static string $resource = ArticleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
