<?php

declare(strict_types=1);

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;
use function JmesPath\search;

class SearchFilter implements Filter
{
    public function __invoke(Builder $query, $term, string $property): void
    {
       if(is_array($term))
       {
           $term = implode(',', $term);
       }
        $query->search($term);
    }
}
