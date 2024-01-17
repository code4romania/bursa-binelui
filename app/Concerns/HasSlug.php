<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Localizable;

trait HasSlug
{
    use Localizable;

    public function initializeHasSlug(): void
    {
        $this->fillable[] = 'slug';
    }

    public function getSlugFieldSource(): string
    {
        return $this->slugFieldSource ?? 'title';
    }

    public static function bootHasSlug(): void
    {
        static::creating(fn (Model $model) => $model->fillSlugs());
        static::updating(fn (Model $model) => $model->fillSlugs());
    }

    public function scopeForSlug(Builder $query, string $slug, ?string $locale = null): Builder
    {
        return $query->where($this->getSlugColumn($locale), $slug);
    }

    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        if ($field === 'slug') {
            $field = $this->getSlugColumn();
        }

        return parent::resolveRouteBindingQuery($query, $value, $field);
    }

    protected function getSlugColumn(?string $locale = null): string
    {
        $column = 'slug';

        if ($this->slugIsTranslatable()) {
            $column .= '->' . ($locale ?? app()->getLocale());
        }

        return $column;
    }

    protected function fillSlugs(): void
    {
        if (
            ! \array_key_exists('slug', $this->attributes) ||
            ! \array_key_exists($this->getSlugFieldSource(), $this->attributes)
        ) {
            return;
        }

        if ($this->slugIsTranslatable()) {
            $slugs = $this->getTranslationsWithFallback('slug');

            locales()->each(
                fn (string $locale) => $this->withLocale($locale, function () use ($slugs) {
                    $slug = Str::slug($slugs[app()->getLocale()]);

                    if (! $slug || $this->slugAlreadyUsed($slug)) {
                        $this->slug = $this->generateSlug();
                    }
                })
            );
        } else {
            locales()->each(function () {
                $this->slug = Str::slug($this->slug);

                if (! $this->slug || ! $this->slugAlreadyUsed($this->slug)) {
                    $this->slug = $this->generateSlug();
                }
            });
        }
    }

    public function generateSlug(): string
    {
        $base = $slug = Str::slug($this->{$this->getSlugFieldSource()});
        $suffix = 1;


        while ($this->slugAlreadyUsed($slug)) {
            $slug = Str::slug($base . '_' . $suffix++);
        }

        return $slug;
    }

    protected function slugAlreadyUsed(string $slug): bool
    {
        $query = static::forSlug($slug)
            ->withoutGlobalScopes();

        if ($this->exists) {
            $query->where($this->getKeyName(), '!=', $this->getKey());
        }

        return $query->exists();
    }

    protected function slugIsTranslatable(): bool
    {
        return property_exists($this, 'translatable') && \in_array('slug', $this->translatable);
    }

    public function getUrlAttribute(): ?string
    {
        $key = $this->getMorphClass();

        $slug = $this->slugIsTranslatable()
            ? $this->getTranslationWithoutFallback('slug', app()->getLocale())
            : $this->slug;

        if (! $slug) {
            return null;
        }

        return route('front.' . Str::plural($key) . '.show', [
            'locale' => app()->getLocale(),
            $key => $slug,
        ]);
    }
}
