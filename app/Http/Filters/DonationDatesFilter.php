<?php

declare(strict_types=1);

namespace App\Http\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DonationDatesFilter implements Filter
{
    public function __invoke(Builder $query, $dates, string $property): void
    {
        if (! empty($dates[0])) {
            $start = Carbon::createFromFormat('Y-m', $dates[0])->startOfDay();
            $query->whereDate('created_at', '>=', $start);
        }
        if (! empty($dates[1])) {
            $end = Carbon::createFromFormat('Y-m', $dates[1])->endOfDay();
            $query->whereDate('created_at', '<=', $end);
        }
    }
}
