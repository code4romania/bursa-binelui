<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class DonationsOverviewWidget extends StatsOverviewWidget
{
    public ?Model $record = null;

    protected function getCards(): array
    {
        return [
            Card::make(
                __('donation.stats.charged'),
                $this->record->donations()
                    ->whereCharged()
                    ->count()
            ),

            Card::make(
                __('donation.stats.charged_amount'),
                Number::currency(
                    $this->record->donations()
                        ->whereCharged()
                        ->sum('amount'),
                    'RON',
                    app()->getLocale()
                )
            ),

            Card::make(
                __('donation.stats.pending'),
                $this->record->donations()
                    ->wherePending()
                    ->count()
            ),

            Card::make(
                __('donation.stats.failed'),
                $this->record->donations()
                    ->whereFailed()
                    ->count()
            ),
        ];
    }
}
