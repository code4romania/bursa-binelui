<?php

declare(strict_types=1);

namespace App\Filament\Resources\ChampionshipResource\Pages;

use App\Filament\Resources\ChampionshipResource;
use Filament\Resources\Pages\CreateRecord;

class CreateChampionship extends CreateRecord
{
    protected static string $resource = ChampionshipResource::class;
}
