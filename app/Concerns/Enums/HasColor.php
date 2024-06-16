<?php

declare(strict_types=1);

namespace App\Concerns\Enums;

use Illuminate\Support\Str;

trait HasColor
{
    public static function colors(): array
    {
        return [];
    }

    public static function flipColors(): array
    {
        return collect(static::colors())
            ->flip()
            ->all();
    }

    public function color(): ?string
    {
        return collect([
            static::colors()[$this->value] ?? 'bg-gray-100',
            Str::slug($this->value),
        ])->join(' ');
    }
}
