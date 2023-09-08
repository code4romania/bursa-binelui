<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ActivityDomain;
use App\Models\County;
use App\Models\ProjectCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public function getActivityDomains(): array
    {
        return Cache::remember('activity-domains', static::optionsCacheTTL(), function () {
            return ActivityDomain::query()
                ->addSelect('id as value')
                ->addSelect('name as label')
                ->get()
                ->toArray();
        });
    }

    public function getCounties(): array
    {
        return Cache::remember('counties', static::optionsCacheTTL(), function () {
            return County::query()
                ->addSelect('id as value')
                ->addSelect('name as label')
                ->get()
                ->toArray();
        });
    }

    public function getProjectCategories(): array
    {
        return Cache::remember('project-categories', static::optionsCacheTTL(), function () {
            return ProjectCategory::query()
                ->addSelect('id as value')
                ->addSelect('name as label')
                ->get()
                ->toArray();
        });
    }

    private static function optionsCacheTTL(): int
    {
        if (app()->isLocal()) {
            return MINUTE_IN_SECONDS;
        }

        return HOUR_IN_MINUTES;
    }
}
