<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ProjectOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make(__('project.labels.all_projects'), Project::query()->count()),
            Card::make(__('project.labels.approved'), Project::query()->whereIsApproved()->count()),
            Card::make(__('project.labels.rejected'), Project::query()->whereIsRejected()->count()),
            Card::make(__('project.labels.pending'), Project::query()->whereIsPending()->count()),
        ];
    }
}
