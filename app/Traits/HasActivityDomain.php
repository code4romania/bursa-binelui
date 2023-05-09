<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\ActivityDomain;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait HasActivityDomain
{
    public function scopeActivityDomains(Builder $query, array|string|Collection|ActivityDomain $activityDomains): void
    {
        $query->whereJsonContains('activity_domains', $activityDomains);
    }
}
