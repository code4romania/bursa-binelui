<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

class DonationAmountOverview extends BaseDonationWidget
{
    protected function getData(): array
    {
        $selectedFields = 'sum(amount) as total';
        $chartInterval = $this->getChartInterval();
        $formatDate = $this->getFormatDate();

        $whereCreatedCondition = $this->getCreatedCondition();

        $data = $this->getChartData($formatDate, $whereCreatedCondition, $chartInterval, $selectedFields);

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
