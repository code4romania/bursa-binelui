<?php

declare(strict_types=1);

namespace App\Concerns\Enums;

trait HasLabel
{
    protected function labelKeyPrefix(): ?string
    {
        return null;
    }

    public function label(): string
    {
        $label = collect([$this->labelKeyPrefix(), $this->value])
            ->filter()
            ->implode('.');

        return __($label);
    }
}
