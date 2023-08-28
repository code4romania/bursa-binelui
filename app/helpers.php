<?php

declare(strict_types=1);

use Illuminate\Support\Collection;

function locales(): Collection
{
    return collect(config('filament-spatie-laravel-translatable-plugin.default_locales'));
}
