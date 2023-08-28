<?php

declare(strict_types=1);

namespace App\Concerns;

use Spatie\Translatable\HasTranslations as BaseHasTranslations;

trait HasTranslations
{
    use BaseHasTranslations;

    public function getTranslationsWithFallback(?string $key = null): array
    {
        return locales()
            ->mapWithKeys(fn (string $locale) => [$locale => null])
            ->merge($this->getTranslations($key))
            ->toArray();
    }
}
