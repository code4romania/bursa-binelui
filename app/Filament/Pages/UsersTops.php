<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Pages\Page;

class UsersTops extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.users-tops';

    protected static ?int $navigationSort = 7;

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.statistics');
    }

    protected static function getNavigationLabel(): string
    {
        return __('statistics.navigation.labels.users_tops');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\UserResource\Widgets\UsersTops::class,
        ];
    }

    protected function getHeaderWidgetsColumns(): int|string|array
    {
        return 1;
    }
}
