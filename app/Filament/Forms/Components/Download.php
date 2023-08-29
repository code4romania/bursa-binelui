<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Download extends Component
{
    use Concerns\HasHelperText;
    use Concerns\HasHint;
    use Concerns\HasName;

    protected string $view = 'forms.components.download';

    protected string | Closure $collectionName = 'default';

    final public function __construct(string $collectionName)
    {
        $this->collectionName($collectionName);
        $this->statePath($collectionName);
    }

    public static function make(string $collectionName): static
    {
        $static = app(static::class, ['collectionName' => $collectionName]);
        $static->configure();

        return $static;
    }

    public function collectionName(string | Closure $collectionName): static
    {
        $this->collectionName = $collectionName;

        return $this;
    }

    public function getCollectionName(): string
    {
        return $this->evaluate($this->collectionName);
    }

    public function getDownloadItems(): Collection
    {
        return $this->getRecord()
            ->getMedia($this->getCollectionName())
            ->map(fn (Media $media) => [
                'url' => $media->getFullUrl(),
                'name' => $media->name . '.' . $media->extension,
            ]);
    }
}
