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
                ->record($this->record)
                ->disabled(fn () => (bool) $this->record->eligible)
                ->hidden(fn () => (bool) $this->record->eligible),

            GalaProjectResource\Actions\Page\MarkAsIneligibleAction::make()
                ->record($this->record)
                ->disabled(fn () => ! $this->record->eligible)
                ->hidden(fn () => ! $this->record->eligible),

            GalaProjectResource\Actions\Page\AddToShortListAction::make()
                ->record($this->record)
                ->disabled(fn () => (bool) $this->record->short_list)
                ->hidden(fn () => (bool) $this->record->short_list),

            GalaProjectResource\Actions\Page\RemoveFromShortListAction::make()
                ->record($this->record)
                ->disabled(fn () => ! $this->record->short_list)
                ->hidden(fn () => ! $this->record->short_list),
        ];
    }

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }
}
