<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use Filament\Resources\Pages\Page;

class OrganisationIndex extends Page
{
    protected static string $resource = OrganizationResource::class;

    protected static string $view = 'filament.resources.organization-resource.pages.organisation-index';

    protected static ?string $title = '';

    protected function getHeaderWidgets(): array
    {
        return [
            OrganizationResource\Widgets\NewOrganizationWidget::class,
            OrganizationResource\Widgets\ApprovedOrganizationWidget::class,
            OrganizationResource\Widgets\RejectedOrganizationWidget::class,
        ];
    }
}
