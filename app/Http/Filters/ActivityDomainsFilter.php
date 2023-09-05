<?php

declare(strict_types=1);

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\Filters\Filter;

class ActivityDomainsFilter implements Filter
{
    public function __invoke(Builder $query, $domains, string $property): void
    {
        $query->whereHas(
            'activityDomains',
            fn (Builder $query) => $query->whereIn('activity_domains.id', Arr::wrap($domains))
        );
    }
}
