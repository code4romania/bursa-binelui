<?php

declare(strict_types=1);

namespace App\Http\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class ProjectDonationsCountSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): Builder
    {
        return $query
            ->withCount('donations')
            ->orderBy('donations_count', $descending ? 'desc' : 'asc');
    }
}
