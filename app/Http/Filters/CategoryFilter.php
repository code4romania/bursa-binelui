<?php

declare(strict_types=1);

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CategoryFilter implements Filter
{
    public function __invoke(Builder $query, $categories, string $property): void
    {
        $categories = collect($categories)
            ->flatten()
            ->all();

        $query->whereHas(
            'categories',
            fn (Builder $query) => $query->whereIn('categories.id', $categories)
        );
    }
}
