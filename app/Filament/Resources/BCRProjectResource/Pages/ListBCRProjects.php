<?php

declare(strict_types=1);

namespace App\Filament\Resources\BCRProjectResource\Pages;

use App\Filament\Resources\BCRProjectResource;
use App\Models\BCRProject;
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

    protected function getTableHeading(): string
    {
        return __('bcr-project.header', ['number' => BCRProject::count()]) ;
    }
}
