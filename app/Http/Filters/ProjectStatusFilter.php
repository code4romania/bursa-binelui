<?php

declare(strict_types=1);

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class ProjectStatusFilter implements Filter
{
    public function __invoke(Builder $query, $status, string $property): Builder
    {
        if ($status === 'active') {
            return $query->whereIsOpen();
        }

        if ($status === 'inactive') {
            return $query->whereIsClosed();
        }

        return $query;
    }
}
