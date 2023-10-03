<?php

declare(strict_types=1);

namespace App\Filament\Resources\Articles\CategoryResource\Pages;

use App\Filament\Resources\Articles\CategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateCategory extends CreateRecord
{
    use Translatable;

    protected static string $resource = CategoryResource::class;
}
