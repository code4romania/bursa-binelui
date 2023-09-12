<?php

declare(strict_types=1);

namespace App\Http\Resources\Columns;

use Illuminate\Contracts\Support\Arrayable;

class TableColumn implements Arrayable
{
    public string $field;

    public string $label;

    public bool $sortable = false;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    public static function make(string $field): static
    {
        return new static($field);
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function sortable(bool $sortable = true): static
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
