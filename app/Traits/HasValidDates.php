<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasValidDates
{
    public function scopeValidDates(Builder $query, string $startColumn = 'start_date', string $endColumn = 'end_date'): Builder
    {
        return $query
            ->whereNotNull($startColumn)
            ->whereNotNull($endColumn)
            ->whereColumn($startColumn, '<=', $endColumn);
    }
}
