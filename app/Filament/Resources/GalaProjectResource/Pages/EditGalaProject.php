<?php

declare(strict_types=1);

namespace App\Filament\Resources\GalaProjectResource\Pages;

use App\Filament\Resources\GalaProjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGalaProject extends EditRecord
{
    protected static string $resource = GalaProjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
