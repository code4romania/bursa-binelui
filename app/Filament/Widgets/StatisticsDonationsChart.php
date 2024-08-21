<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Donation;
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\DB;
use Tpetry\QueryExpressions\Function\Aggregate\Count;
use Tpetry\QueryExpressions\Language\Alias;

class StatisticsDonationsChart extends LineChartWidget
{
    protected int | string | array $columnSpan = 3;

    protected static ?string $pollingInterval = null;

    protected function getHeading(): ?string
    {
        return __('statistics.labels.donations_count');
    }

    protected function getData(): array
    {
        $interval = 'month';

        $data = Donation::query()
            ->select([
                new Alias(new Count('*'), 'total'),
                new Alias(DB::raw("DATE_FORMAT(created_at, '%Y %m')"), $interval),
            ])
            ->where('created_at', '>', now()->subYear(1))
            ->whereCharged()
            ->groupBy($interval)
            ->orderBy($interval)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('donation.label.plural'),
                    'data' => $data->map(fn ($value) => $value->total),
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->$interval),
        ];
    }
}
