<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use App\Filament\Resources\OrganizationResource\Widgets\ApprovedOrganizationsWidget;
use App\Filament\Resources\OrganizationResource\Widgets\PendingChangesOrganizationsWidget;
use App\Filament\Resources\OrganizationResource\Widgets\PendingOrganizationsWidget;
use App\Filament\Resources\OrganizationResource\Widgets\RejectedOrganizationsWidget;
use Filament\Resources\Pages\Page;

class ListOrganizations extends Page
{
    protected static string $resource = OrganizationResource::class;

    protected static string $view = 'filament.resources.organization-resource.pages.organisation-index';

    protected static ?string $title = '';

    protected function getHeaderWidgets(): array
    {
        return [
            PendingOrganizationsWidget::class,
            PendingChangesOrganizationsWidget::class,
            ApprovedOrganizationsWidget::class,
            RejectedOrganizationsWidget::class,
        ];
    }

    protected function getHeaderWidgetsColumns(): int
    {
        return 1;
    }
}
