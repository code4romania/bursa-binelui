<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\DB;
use Tpetry\QueryExpressions\Function\Aggregate\Count;
use Tpetry\QueryExpressions\Language\Alias;

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
        $interval = 'month';

        $data = Project::query()
            ->withoutGlobalScope('total_amount')
            ->select([
                new Alias(new Count('*'), 'total'),
                new Alias(DB::raw("DATE_FORMAT(created_at, '%Y %m')"), $interval),
            ])
            ->where('created_at', '>', now()->subYear(1))
            ->without([
                'media',
                'organization',
                'counties',
                'categories',
            ])
            ->groupBy($interval)
            ->orderBy($interval)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('project.label.plural'),
                    'data' => $data->map(fn ($value) => $value->total),
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->$interval),
        ];
    }
}
