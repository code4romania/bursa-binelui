<?php

declare(strict_types=1);

namespace App\Filament\Resources\WebpageResource\Pages;

use App\Filament\Resources\WebpageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWebpage extends CreateRecord
{
    protected static string $resource = WebpageResource::class;
}
