<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Enums\ProjectStatus;
use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\ProjectResource\Actions\Pages\ApproveProjectAction;
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
            ApproveProjectAction::make()
                ->record($this->record)
                ->hidden(fn () => $this->record->status == ProjectStatus::approved),
            Action::make('Reject')
                ->action(function () {
                    $this->record->status = ProjectStatus::rejected->value;
                    $this->record->save();
                })
                ->requiresConfirmation()->hidden(fn () => $this->record->status == ProjectStatus::rejected->value),
        ];
    }
}
