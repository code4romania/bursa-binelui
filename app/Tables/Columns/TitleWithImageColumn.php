<?php

declare(strict_types=1);

namespace App\Tables\Columns;

use Closure;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\Concerns;

class TitleWithImageColumn extends Column
{
    use Concerns\HasFontFamily;
    use Concerns\HasSize;
    use Concerns\HasWeight;

    protected string $view = 'tables.columns.title-with-image-column';

    protected string | Closure | null $image = null;

    protected string | Closure | null $title = null;

    protected string | Closure | null $description = null;

    public function image(string | Closure | null $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->evaluate($this->image);
    }

    public function title(string | Closure | null $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->evaluate($this->title);
    }

    public function description(string | Closure | null $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->evaluate($this->description);
    }
}
