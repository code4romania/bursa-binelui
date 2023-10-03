<?php

declare(strict_types=1);

use Illuminate\Support\Collection;

if (! function_exists('locales')) {
    function locales(): Collection
    {
        return collect(config('filament-spatie-laravel-translatable-plugin.default_locales'));
    }
}

if (! function_exists('money_format')) {
    function money_format($number, $decimals = 0): string
    {
        $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);

        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $decimals);

        return $formatter->formatCurrency((float) $number, 'RON');
    }
}
