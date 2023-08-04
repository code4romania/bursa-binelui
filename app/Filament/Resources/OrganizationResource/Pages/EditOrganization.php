<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Enums\OrganizationStatus;
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
            Action::make('Approve')
                ->action(function () {
                    $this->record->status = OrganizationStatus::approved->value;
                    $this->record->save();
                })
                ->requiresConfirmation()->hidden(fn () => $this->record->status == OrganizationStatus::approved->value),
            Action::make('Reject')
                ->action(function () {
                    $this->record->status = OrganizationStatus::rejected->value;
                    $this->record->save();
                })
                ->requiresConfirmation()->hidden(fn () => $this->record->status == OrganizationStatus::rejected->value),
        ];
    }
}
