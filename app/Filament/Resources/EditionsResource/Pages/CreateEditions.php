<?php

declare(strict_types=1);

namespace App\Filament\Resources\EditionsResource\Pages;

use App\Filament\Resources\EditionsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEditions extends CreateRecord
{
    protected static string $resource = EditionsResource::class;
}
