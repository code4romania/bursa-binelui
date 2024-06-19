<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Donation;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsCards extends StatsOverviewWidget
{
    protected static ?string $pollingInterval = null;

    /**
     * @return Carbon
     */
    public function getLastEndDate(string $cardLabel): Carbon
    {
        if ($cardLabel === 'year') {
            return now()->subYear(2);
        }

        return now()->subMonth(2);
    }

    /**
     * @return Carbon
     */
    private function getCurrentEndDate(string $cardLabel): Carbon
    {
        if ($cardLabel === 'year') {
            return now()->subYear(1);
        }

        return now()->subMonth(1);
    }

    /**
     * @return array
     */
    private function getProjectCard(string $cardLabel): Card
    {
        $currentAvg = Project::query()
            ->where('start', '<', now())
            ->where('end', '>', $this->getCurrentEndDate($cardLabel))
            ->avg(DB::raw('HOUR(TIMEDIFF(end, start))')) / 24;

        $lastAvg = Project::query()
            ->where('start', '<', $this->getCurrentEndDate($cardLabel))
            ->where('end', '>', $this->getLastEndDate($cardLabel))
            ->avg(DB::raw('HOUR(TIMEDIFF(end, start))')) / 24;

        $currentGrandThanLast = $currentAvg > $lastAvg;

        $color = $currentGrandThanLast ? 'success' : 'danger';
        $icon = $currentGrandThanLast ? 'heroicon-s-trending-up' : 'heroicon-s-trending-down';

        $description = $cardLabel === 'year' ?
            (
                $currentGrandThanLast ?
                __('statistics.labels.current_year_grand_than_last_year', ['number' => $currentAvg - $lastAvg]) :
                __('statistics.labels.current_year_less_than_last_year', ['number' => $lastAvg - $currentAvg])
            ) :
            (
                $currentGrandThanLast ?
                __('statistics.labels.current_month_grand_than_last_month', ['number' => $currentAvg - $lastAvg]) :
                __('statistics.labels.current_month_less_than_last_month', ['number' => $lastAvg - $currentAvg])
            );

        $chart = array_map(function () use ($currentAvg, $lastAvg) {
            return rand(min((int) $currentAvg, (int) $lastAvg), max((int) $currentAvg, (int) $lastAvg));
        }, array_fill(0, 20, null));
        array_unshift($chart, $lastAvg);
        $chart[] = $currentAvg;

        return Card::make(
            __("statistics.labels.project_{$cardLabel}"),
            __('statistics.labels.no_of_days', ['number' => round($currentAvg, 2)])
        )
            ->descriptionColor($color)
            ->descriptionIcon($icon)
            ->description($description)
            ->chartColor($color)
            ->chart($chart);
    }

    protected function getCards(): array
    {
        return [
            $this->getProjectCard('monthly'),
            $this->getProjectCard('year'),
            $this->getDonationCard('year'),
        ];
    }

    private function getDonationCard(string $string)
    {
        $currentYear = Donation::query()
            ->whereBetween('created_at', [now()->subYear(1), now()])
            ->sum('amount');

        $lastYear = Donation::query()
            ->whereBetween('created_at', [now()->subYear(2), now()->subYear(1)])
            ->sum('amount');

        $chart = array_map(function () use ($currentYear, $lastYear) {
            return rand(min((int) $currentYear, (int) $lastYear), max((int) $currentYear, (int) $lastYear));
        }, array_fill(0, 20, null));
        array_unshift($chart, $lastYear);
        $chart[] = $currentYear;

        $currentGrandThanLast = $currentYear > $lastYear;

        $color = $currentGrandThanLast ? 'success' : 'danger';
        $icon = $currentGrandThanLast ? 'heroicon-s-trending-up' : 'heroicon-s-trending-down';

        $description =
            $currentGrandThanLast ?
                __('statistics.labels.donation_grand_than_last_year', ['amount' => $currentYear - $lastYear]) :
                __('statistics.labels.donation_less_than_last_year', ['amount' => $lastYear - $currentYear]);

        return Card::make(
            __('statistics.labels.donations_amount'),
            __('statistics.labels.amount_in_currency', ['amount' => $currentYear])
        )
            ->descriptionColor($color)
            ->descriptionIcon($icon)
            ->description($description)
            ->chartColor($color)
            ->chart($chart);
    }
}
