<?php

declare(strict_types=1);

namespace App\Filament\Resources\BCRProjectResource\Pages;

use App\Filament\Resources\BCRProjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBCRProject extends EditRecord
{
    protected static string $resource = BCRProjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
