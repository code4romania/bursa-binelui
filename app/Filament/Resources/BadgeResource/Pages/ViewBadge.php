<?php

declare(strict_types=1);

namespace App\Filament\Resources\BadgeResource\Pages;

use App\Filament\Resources\BadgeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBadge extends ViewRecord
{
    protected static string $resource = BadgeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
