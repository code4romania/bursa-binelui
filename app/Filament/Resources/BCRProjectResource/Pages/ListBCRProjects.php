<?php

namespace App\Filament\Resources\BCRProjectResource\Pages;

use App\Filament\Resources\BCRProjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBCRProjects extends ListRecords
{
    protected static string $resource = BCRProjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
