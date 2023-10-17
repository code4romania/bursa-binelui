<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use App\Filament\Resources\OrganizationResource\Actions\Pages\ApproveOrganizationAction;
use App\Filament\Resources\OrganizationResource\Actions\Pages\ApproveProjectAction;
use App\Filament\Resources\OrganizationResource\Actions\Pages\DeactivateOrganizationAction;
use App\Filament\Resources\OrganizationResource\Actions\Pages\ReactivateOrganizationAction;
use App\Filament\Resources\OrganizationResource\Actions\Pages\RejectProjectAction;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrganization extends ViewRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function getActions(): array
    {
        return [
            EditAction::make(),

            ApproveOrganizationAction::make()
                ->record($this->getRecord())
                ->visible($this->getRecord()->isPending()),

            ApproveOrganizationAction::make()
                ->record($this->getRecord())
                ->visible($this->getRecord()->isPending()),

            ReactivateOrganizationAction::make()
                ->record($this->getRecord())
                ->visible($this->getRecord()->isDisabled()),

            DeactivateOrganizationAction::make()
                ->record($this->getRecord())
                ->visible($this->getRecord()->isActive()),

        ];
    }

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }

    public function getFormTabLabel(): ?string
    {
        return __('organization.organization');
    }
}
