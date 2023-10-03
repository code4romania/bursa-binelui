<?php

declare(strict_types=1);

namespace App\Filament\Resources\Articles\CategoryResource\Pages;

use App\Filament\Resources\Articles\CategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;

class EditCategory extends EditRecord
{
    use Translatable;

    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
