<?php

declare(strict_types=1);

namespace App\Concerns;

trait ArrayableEnum
{
    public static function names(): array
    {
        return collect(self::cases())
            ->pluck('name')
            ->all();
    }

    public static function values(): array
    {
        return collect(self::cases())
            ->pluck('value')
            ->all();
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $case) => [
                $case->value => $case->label(),
            ])
            ->all();
    }

    public function label(): string
    {
        $label = collect([$this->translationKeyPrefix(), $this->value])
            ->filter()
            ->implode('.');

        return __($label);
    }

    protected function translationKeyPrefix(): ?string
    {
        return null;
    }
}
