<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Widgets\StatisticsCards;
use App\Filament\Widgets\StatisticsDonationsChart;
use App\Filament\Widgets\StatisticsProjectsChart;
use Filament\Pages\Page;

class Statistics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.statistics';

    protected static ?int $navigationSort = 7;

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.statistics');
    }

    protected static function getNavigationLabel(): string
    {
        return __('statistics.navigation.labels.statistics');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatisticsCards::class,
            StatisticsProjectsChart::class,
            StatisticsDonationsChart::class,
        ];
    }

    protected function getHeaderWidgetsColumns(): int|string|array
    {
        return 6;
    }
}
