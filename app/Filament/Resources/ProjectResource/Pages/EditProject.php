<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Enums\ProjectStatus;
use App\Filament\Resources\ProjectResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('Approve')
                ->action(function () {
                    $this->record->status = ProjectStatus::approved->value;
                    $this->record->save();
                })
                ->requiresConfirmation()->hidden(fn () => $this->record->status == ProjectStatus::approved->value),
            Action::make('Reject')
                ->action(function () {
                    $this->record->status = ProjectStatus::rejected->value;
                    $this->record->save();
                })
                ->requiresConfirmation()->hidden(fn () => $this->record->status == ProjectStatus::rejected->value),
        ];
    }
}
