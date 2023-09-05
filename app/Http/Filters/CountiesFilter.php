<?php

declare(strict_types=1);

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\Filters\Filter;

class CountiesFilter implements Filter
{
    public function __invoke(Builder $query, $counties, string $property): void
    {
        $query->whereHas(
            'counties',
            fn (Builder $query) => $query->whereIn('counties.id', Arr::wrap($counties))
        );
    }
}
