<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\ContactMessageResource\Actions\Pages\ToggleMarkAsReadAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getActions(): array
    {
        return [
            ToggleMarkAsReadAction::make()->record($this->getRecord()),
        ];
    }
}
