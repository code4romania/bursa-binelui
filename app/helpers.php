<?php

declare(strict_types=1);

use Illuminate\Support\Collection;

function locales(): Collection
{
    return collect(config('filament-spatie-laravel-translatable-plugin.default_locales'));
}

function money_format($number, $decimals = 0): string
{
    $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);

    $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $decimals);

    return $formatter->formatCurrency($number, 'RON');
}
