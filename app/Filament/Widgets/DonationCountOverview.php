<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

class DonationCountOverview extends BaseDonationWidget
{
    protected function getData(): array
    {
        $selectedField = 'count(id) as count';

        $chartInterval = $this->getChartInterval();
        $formatDate = $this->getFormatDate();

        $whereCreatedCondition = $this->getCreatedCondition();

        $data = $this->getChartData($formatDate, $whereCreatedCondition, $chartInterval, $selectedField);

        return [
            'datasets' => [
                [
                    'label' => __('donation.labels.count'),
                    'data' => $data->map(fn ($value) => $value->count),
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->$chartInterval),
        ];
    }
}
