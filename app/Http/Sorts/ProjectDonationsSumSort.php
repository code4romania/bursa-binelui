<?php

declare(strict_types=1);

namespace App\Http\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class ProjectDonationsSumSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): Builder
    {
        return $query
            ->withSum('donations', 'amount')
            ->orderBy('donations_sum_amount', $descending ? 'desc' : 'asc');
    }
}
