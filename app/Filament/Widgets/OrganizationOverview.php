<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Organization;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class OrganizationOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make(__('organization.label.plural'), Organization::query()->count()),
            Card::make(__('organization.labels.approved'), Organization::query()->isApproved()->count()),
            Card::make(__('organization.labels.rejected'), Organization::query()->isRejected()->count()),
            Card::make(__('organization.labels.pending'), Organization::query()->isPending()->count()),
        ];
    }
}
