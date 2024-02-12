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
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware(['web', 'auth', 'auth.session', 'verified', 'hasOrganization'])
                ->prefix('dashboard')
                ->name('dashboard.')
                ->group(base_path('routes/dashboard.php'));

            Route::middleware(config('filament.middleware.base'))
                ->domain(config('filament.domain'))
                ->prefix(config('filament.path'))
                ->name('filament.')
                ->group(base_path('routes/filament.php'));

            Route::middleware('web')
                ->group(base_path('routes/redirects.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(config('throttle.register_limit'))->by($request->ip());
        });

        RateLimiter::for('make-donation', function (Request $request) {
            return Limit::perMinute(config('throttle.donation_limit'))->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('register-volunteer', function (Request $request) {
            return Limit::perMinute(config('throttle.volunteer_limit'))->by($request->user()?->id ?: $request->ip());
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
