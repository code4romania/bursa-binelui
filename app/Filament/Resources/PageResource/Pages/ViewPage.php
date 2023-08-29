<?php

declare(strict_types=1);

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Pages\ViewRecord\Concerns\Translatable;

class ViewPage extends ViewRecord
{
    use Translatable;

    protected static string $resource = PageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
            // Actions\LocaleSwitcher::make(),
        ];
    }
}
