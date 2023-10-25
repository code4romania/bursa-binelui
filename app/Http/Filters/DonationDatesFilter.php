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
        $start = Carbon::createFromFormat('Y-m-d', $dates[0]);
        $end = Carbon::createFromFormat('Y-m-d', $dates[1]);

        $query->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end);
    }
}
