<?php

declare(strict_types=1);

namespace App\Filament\Resources\GalaProjectResource\Pages;

use App\Filament\Resources\GalaProjectResource;
use Filament\Resources\Pages\ViewRecord;

class ViewGalaProject extends ViewRecord
{
    protected static string $resource = GalaProjectResource::class;

    protected function getActions(): array
    {
        return [
            GalaProjectResource\Actions\Page\MarkAsEligibleAction::make()
                ->record($this->getRecord()),

            GalaProjectResource\Actions\Page\MarkAsIneligibleAction::make()
                ->record($this->getRecord()),

            GalaProjectResource\Actions\Page\AddToShortListAction::make()
                ->record($this->getRecord()),

            GalaProjectResource\Actions\Page\RemoveFromShortListAction::make()
                ->record($this->getRecord()),
        ];
    }

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }
}
