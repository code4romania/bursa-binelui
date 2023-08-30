<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use App\Filament\Resources\OrganizationResource\Actions\Pages\ApproveAction;
use App\Filament\Resources\OrganizationResource\Actions\Pages\DeactivateAction;
use App\Filament\Resources\OrganizationResource\Actions\Pages\ReactivateAction;
use App\Filament\Resources\OrganizationResource\Actions\Pages\RejectAction;
use App\Filament\Resources\OrganizationResource\Widgets\OrganizationActivityWidget;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrganization extends ViewRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function getActions(): array
    {
        return [
            EditAction::make(),

            ApproveAction::make()
                ->record($this->getRecord())
                ->visible($this->getRecord()->isPending()),

            RejectAction::make()
                ->record($this->getRecord())
                ->visible($this->getRecord()->isPending()),

            ReactivateAction::make()
                ->record($this->getRecord())
                ->visible($this->getRecord()->isDisabled()),

            DeactivateAction::make()
                ->record($this->getRecord())
                ->visible($this->getRecord()->isActive()),

        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            OrganizationActivityWidget::class,
        ];
    }
}
