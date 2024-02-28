<?php

declare(strict_types=1);

namespace App\Filament\Resources\EditionsResource\Pages;

use App\Filament\Resources\EditionsResource;
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
