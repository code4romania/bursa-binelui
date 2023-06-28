<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Championship;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        tap($this->app->isLocal(), function (bool $shouldBeEnabled) {
            Model::preventLazyLoading($shouldBeEnabled);
            Model::preventAccessingMissingAttributes($shouldBeEnabled);
        });

        Championship::observe(\App\Observers\ChampionshipObserver::class);

        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/app.css');

            Filament::registerScripts([
                app(Vite::class)('resources/js/app.js'),
            ]);

            Filament::registerNavigationItems([
                NavigationItem::make('Participanți')
                    ->url('#', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-user-group')
                    ->activeIcon('heroicon-s-presentation-chart-line')
                    ->group('Campionatul de bine')
                    ->sort(9),
                NavigationItem::make('Cereri inscriere')
                    ->url('#', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->activeIcon('heroicon-s-presentation-chart-line')
                    ->group('Campionatul de bine')
                    ->sort(10),
                NavigationItem::make('Ediția curentă')
                    ->url('#', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->activeIcon('heroicon-s-presentation-chart-line')
                    ->group('Campionatul de bine')
                    ->sort(11),

                NavigationItem::make('Participanți')
                    ->url('#', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-user-group')
                    ->activeIcon('heroicon-s-presentation-chart-line')
                    ->group('Gale regionale')
                    ->sort(12),
                NavigationItem::make('Cereri inscriere')
                    ->url('#', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->activeIcon('heroicon-s-presentation-chart-line')
                    ->group('Gale regionale')
                    ->sort(13),
                NavigationItem::make('Ediția in desfășurare')
                    ->url('#', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->activeIcon('heroicon-s-presentation-chart-line')
                    ->group('Gale regionale')
                    ->sort(14),
                NavigationItem::make('Ediția anterioare')
                    ->url('#', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->activeIcon('heroicon-s-presentation-chart-line')
                    ->group('Gale regionale')
                    ->sort(15),
                NavigationItem::make('Raportare')
                    ->url('#', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->activeIcon('heroicon-s-presentation-chart-line')
                    ->group('Date platformă și raportaări')
                    ->sort(15),

            ]);
        });
    }
}
