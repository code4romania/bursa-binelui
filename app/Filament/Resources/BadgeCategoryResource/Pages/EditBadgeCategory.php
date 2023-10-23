<?php

namespace App\Filament\Resources\BadgeCategoryResource\Pages;

use App\Filament\Resources\BadgeCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBadgeCategory extends EditRecord
{
    protected static string $resource = BadgeCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
