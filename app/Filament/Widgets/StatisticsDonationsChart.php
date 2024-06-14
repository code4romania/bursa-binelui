<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\EuPlatescStatus;
use App\Models\Donation;
use DB;
use Filament\Widgets\LineChartWidget;

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
        $selectedFields = 'count(*) as total';
        $chartInterval = 'month';
        $formatDate = "DATE_FORMAT(created_at,'%Y %m') as month";

        $whereCreatedCondition = now()->subYear(1);

        $data = Donation::query()
            ->select(
                [
                    DB::raw($selectedFields),
                    DB::raw($formatDate),
                ]
            )
            ->where('created_at', '>', $whereCreatedCondition)
            ->whereIn('status', [EuPlatescStatus::CHARGED])
            ->groupBy($chartInterval)
            ->orderBy($chartInterval)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('donation.label.plural'),
                    'data' => $data->map(fn ($value) => $value->total),
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->$chartInterval),
        ];
    }
}
