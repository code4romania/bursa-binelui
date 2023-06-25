<?php

declare(strict_types=1);

namespace App\Filament\Resources\ChampionshipResource\Pages;

use App\Filament\Resources\ChampionshipResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChampionships extends ListRecords
{
    protected static string $resource = ChampionshipResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Creaza ediție nouă'),
        ];
    }
}
