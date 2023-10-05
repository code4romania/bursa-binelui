<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware(['web', 'auth', 'verified'])
                ->prefix('dashboard')
                ->name('dashboard.')
                ->group(base_path('routes/dashboard.php'));

            Route::middleware(config('filament.middleware.base'))
                ->domain(config('filament.domain'))
                ->prefix(config('filament.path'))
                ->name('filament.')
                ->group(base_path('routes/filament.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    public static function getAdminUrl(): string
    {
        return route('filament.pages.dashboard');
    }

    public static function getDashboardUrl(): string
    {
        if (auth()->user()->isOrganizationAdmin()) {
            return route('dashboard.main');
        }

        return route('donor.index');
    }

    public static function getChampionshipUrl(): string
    {
        return route('championship');
    }
}
