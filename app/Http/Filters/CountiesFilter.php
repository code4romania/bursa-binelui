<?php

declare(strict_types=1);

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CountiesFilter implements Filter
{
    public function __invoke(Builder $query, $counties, string $property): void
    {
        $counties = collect($counties)
            ->flatten()
            ->all();

        $query->whereHas(
            'counties',
            fn (Builder $query) => $query->whereIn('counties.id', $counties)
        );
    }
}
