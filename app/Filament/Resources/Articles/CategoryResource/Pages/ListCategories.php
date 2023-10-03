<?php

declare(strict_types=1);

namespace App\Filament\Resources\Articles\CategoryResource\Pages;

use App\Filament\Resources\Articles\CategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

class ListCategories extends ListRecords
{
    use Translatable;

    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
