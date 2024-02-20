<?php

namespace App\Filament\Resources\Editions\EditionsResource\Pages;

use App\Filament\Resources\Editions\EditionsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEditions extends ListRecords
{
    protected static string $resource = EditionsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
