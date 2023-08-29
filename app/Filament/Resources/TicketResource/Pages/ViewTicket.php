<?php

declare(strict_types=1);

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Filament\Resources\TicketResource\Actions\ToggleStatusAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected function getActions(): array
    {
        return [
            ToggleStatusAction::make()
                ->record($this->getRecord()),
        ];
    }

    // public function getTitle(): string
    // {
    //     return $this->getRecord()->title;
    // }
}
