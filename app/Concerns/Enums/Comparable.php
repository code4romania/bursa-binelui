<?php

declare(strict_types=1);

namespace App\Concerns\Enums;

trait Comparable
{
    /**
     * Check if this enum matches the given enum instance or value.
     */
    public function is(mixed $enum): bool
    {
        if ($enum instanceof static) {
            return $this->value === $enum->value;
        }

        return $this->value === $enum;
    }
}
