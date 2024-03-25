<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Project;
use DB;
use Filament\Widgets\LineChartWidget;

class StatisticsProjectsChart extends LineChartWidget
{
    protected int | string | array $columnSpan = 3;

    protected static ?string $pollingInterval = null;

    protected function getHeading(): ?string
    {
        return __('statistics.labels.projects_count');
    }

    protected function getData(): array
    {
        $selectedFields = 'count(*) as total';
        $chartInterval = 'month';
        $formatDate = "DATE_FORMAT(created_at,'%Y %m') as month";

        $whereCreatedCondition = now()->subYear(1);

        $data = Project::query()
            ->select(
                [
                    DB::raw($selectedFields),
                    DB::raw($formatDate),
                ]
            )
            ->where('created_at', '>', $whereCreatedCondition)
            ->without(['media',
                'organization',
                'donations',
                'counties',
                'categories',
                'approvedDonations'])
            ->groupBy($chartInterval)
            ->orderBy($chartInterval)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('project.label.plural'),
                    'data' => $data->map(fn ($value) => $value->total),
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->$chartInterval),
        ];
    }
}
