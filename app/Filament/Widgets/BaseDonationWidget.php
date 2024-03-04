<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\EuPlatescStatus;
use App\Models\Donation;
use DB;
use Filament\Widgets\LineChartWidget as BaseWidget;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class BaseDonationWidget extends BaseWidget
{
    /**
     * @param  string     $formatDate
     * @param  Carbon     $whereCreatedCondition
     * @param  string     $chartInterval
     * @return Collection
     */
    protected function getChartData(
        string $formatDate,
        Carbon $whereCreatedCondition,
        string $chartInterval,
        string $selectedField
    ): Collection {
        return Donation::query()
            ->select(
                DB::raw($selectedField),
                DB::raw($formatDate),
            )
            ->where('created_at', '>', $whereCreatedCondition)
            // TODO: add CAPTURE after pr #348
            ->whereIn('status', [EuPlatescStatus::AUTHORIZED])
            ->groupBy($chartInterval)
            ->orderBy($chartInterval)
            ->get();
    }

    /**
     * @return Carbon
     */
    protected function getCreatedCondition(): Carbon
    {
        $filter = $this->filter ?: 'last_week';

        if ($filter == 'last_week') {
            return now()->addDays(-7);
        }

        if ($filter == 'last_month') {
            return now()->addMonths(-1);
        }

        if ($filter == 'last_3_months') {
            return now()->addMonths(-3);
        }

        if ($filter == 'last_6_months') {
            return now()->addMonths(-6);
        }

        return now()->addMonths(-12);
    }

    /**
     * @return string
     */
    protected function getChartInterval(): string
    {
        $filter = $this->filter ?: 'last_week';

        return \in_array($filter, ['last_week', 'last_month']) ? 'day' : 'month';
    }

    /**
     * @return string
     */
    protected function getFormatDate(): string
    {
        $filter = $this->filter ?: 'last_week';
        $formatDate = "DATE_FORMAT(created_at,'%Y %m %d') as day";

        return \in_array($filter, ['last_week', 'last_month']) ? $formatDate :
            "DATE_FORMAT(created_at,'%Y %m') as month";
    }

    protected function getFilters(): array
    {
        return ['last_week' => __('field.last_week'),
            'last_month' => __('field.last_month'),
            'last_3_months' => __('field.last_x_months', ['number' => 3]),
            'last_6_months' => __('field.last_x_months', ['number' => 6]),
            'last_year' => __('field.last_year')];
    }
}
