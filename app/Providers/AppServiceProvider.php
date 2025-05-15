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
use Illuminate\Validation\Rules\Password;
use JeffGreco13\FilamentBreezy\FilamentBreezy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerCarbonMacros();

        Vite::macro('image', fn (string $asset) => $this->asset("resources/images/{$asset}"));

        config([
            'filament.default_filesystem_disk' => config('filesystems.default_public'),
        ]);
        config()
            ->set('filesystems.disks.filament-excel', [
                'driver' => config('filesystems.disks.s3private.driver'),
                'key' => config('filesystems.disks.s3private.key'),
                'secret' => config('filesystems.disks.s3private.secret'),
                'token' => config('filesystems.disks.s3private.token'),
                'region' => config('filesystems.disks.s3private.region'),
                'bucket' => config('filesystems.disks.s3private.bucket'),
                'url' => config('filesystems.disks.s3private.url'),
                'endpoint' => config('filesystems.disks.s3private.endpoint'),
                'use_path_style_endpoint' => config('filesystems.disks.s3private.use_path_style_endpoint'),
                'visibility' => config('filesystems.disks.s3private.visibility'),
                'throw' => config('filesystems.disks.s3private.throw'),
                'root' => config('filesystems.disks.s3private.root') . '/filament-excel',
            ]);
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
            ]);
        });

        $this->setPasswordDefaults();
    }

    private static function passwordDefaults(): Password
    {
        return Password::min(8)
            ->uncompromised();
    }

    protected function setPasswordDefaults(): void
    {
        Password::defaults(function () {
            return static::passwordDefaults();
        });

        FilamentBreezy::setPasswordRules([
            static::passwordDefaults(),
        ]);
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
