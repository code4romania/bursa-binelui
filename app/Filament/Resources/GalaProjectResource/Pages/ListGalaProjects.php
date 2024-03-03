<?php

declare(strict_types=1);

namespace App\Filament\Resources\GalaProjectResource\Pages;

use App\Filament\Resources\GalaProjectResource;
use Filament\Resources\Pages\ListRecords;

class ListGalaProjects extends ListRecords
{
    protected static string $resource = GalaProjectResource::class;

    protected function getActions(): array
    {
        return [];
    }
}
