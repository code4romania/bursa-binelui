<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Widgets\DonationAmountOverview;
use App\Filament\Widgets\DonationCountOverview;
use App\Filament\Widgets\OrganizationOverview;
use App\Filament\Widgets\ProjectOverview;
use App\Filament\Widgets\StatisticsDonationsChart;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    public function getHeaderWidgets(): array
    {
        return [
            OrganizationOverview::class,
            ProjectOverview::class,
            DonationAmountOverview::class,
            DonationCountOverview::class,
        ];
    }

    protected function getHeaderWidgetsColumns(): int
    {
        return 4;
    }
}
