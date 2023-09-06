<?php

declare(strict_types=1);

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\Filters\Filter;

class CategoryFilter implements Filter
{
    public function __invoke(Builder $query, $domains, string $property): void
    {
        $query->whereHas(
            'categories',
            fn (Builder $query) => $query->whereIn('categories.id', Arr::wrap($domains))
        );
    }
}
