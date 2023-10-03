<?php

declare(strict_types=1);

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class AcceptsVolunteersFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): void
    {
        $query->where('accepts_volunteers', (bool) $value);
    }
}
