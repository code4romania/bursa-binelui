<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Pages\Page;

class OrganizationsTops extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.organizations-tops';

    protected static ?int $navigationSort = 7;

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.statistics');
    }

    protected static function getNavigationLabel(): string
    {
        return __('statistics.navigation.labels.organizations_tops');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\OrganizationResource\Widgets\OrganizationsTops::class,
        ];
    }

    protected function getHeaderWidgetsColumns(): int|string|array
    {
        return 1;
    }
}
