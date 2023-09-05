<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Championship;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerCarbonMacros();

        Vite::macro('image', fn (string $asset) => $this->asset("resources/images/{$asset}"));
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

    protected function registerCarbonMacros(): void
    {
        Carbon::macro('toFormattedDate', fn () => $this->translatedFormat(config('forms.components.date_time_picker.display_formats.date')));
        Carbon::macro('toFormattedDateTime', fn () => $this->translatedFormat(config('forms.components.date_time_picker.display_formats.date_time')));
        Carbon::macro('toFormattedDateTimeWithSeconds', fn () => $this->translatedFormat(config('forms.components.date_time_picker.display_formats.date_time_with_seconds')));
        Carbon::macro('toFormattedTime', fn () => $this->translatedFormat(config('forms.components.date_time_picker.display_formats.time')));
        Carbon::macro('toFormattedTimeWithSeconds', fn () => $this->translatedFormat(config('forms.components.date_time_picker.display_formats.time_with_seconds')));
    }
}
