<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class Resource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = null;

    /**
     * Whether to include resource permissions props.
     *
     * @var bool
     */
    public static bool $withPermissions = false;

    public static function withPermissions(): void
    {
        static::$withPermissions = true;
    }

    public function resolve($request = null): array
    {
        $data = parent::resolve($request);

        if (static::$withPermissions) {
            $data['can'] = collect(['view', 'update', 'delete', 'forceDelete', 'restore'])
                ->mapWithKeys(fn (string $ability) => [
                    $ability => auth()->user()->can($ability, $this->resource),
                ])
                ->merge($this->additionalPermissions());
        }

        return $data;
    }

    protected function additionalPermissions(): array
    {
        return [];
    }
}
