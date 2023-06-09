<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Enums\OrganizationStatus;
use App\Enums\ProjectStatus;
use App\Filament\Resources\OrganizationResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditOrganization extends EditRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('Approve')
                ->action(function () {$this->record->status=OrganizationStatus::active->value;$this->record->save();})
                ->requiresConfirmation()->hidden(fn () => $this->record->status == OrganizationStatus::active->value),
            Action::make('Reject')
                ->action(function () {$this->record->status=OrganizationStatus::disabled->value;$this->record->save();})
                ->requiresConfirmation()->hidden(fn () => $this->record->status == OrganizationStatus::disabled->value),
        ];
    }
}
