<?php

declare(strict_types=1);

namespace App\Filament\Resources\BadgeCategoryResource\Pages;

use App\Filament\Resources\BadgeCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBadgeCategory extends CreateRecord
{
    protected static string $resource = BadgeCategoryResource::class;
}
