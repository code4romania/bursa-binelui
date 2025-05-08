<?php

declare(strict_types=1);

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class ProjectNationalFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if ($value) {
            return $query->where('is_national', true);
        }

        if (! $value) {
            return $query->where('is_national', false);
        }

        return $query;
    }
}
