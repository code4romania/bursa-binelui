<?php

declare(strict_types=1);

namespace App\Http\Resources\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection as BaseCollection;
use Illuminate\Support\Str;

abstract class ResourceCollection extends BaseCollection
{
    public string $model;

    protected array $appends = [];

    public function toArray(Request $request): array
    {
        return array_merge([
            'columns' => $this->getColumns(),
            'filter' => $request->query('filter'),
            'sort' => $this->getSort($request),
            'data' => $this->collection,
        ], $this->appends);
    }

    abstract protected function getColumns(): array;

    protected function getSort(Request $request): array
    {
        $column = $request->query('sort');
        $direction = 'asc';

        if (! \is_string($column)) {
            return [
                'column' => null,
                'direction' => null,
            ];
        }

        if (Str::startsWith($column, '-')) {
            $column = ltrim($column, '-');
            $direction = 'desc';
        }

        return [
            'column' => $column,
            'direction' => $direction,
        ];
    }

    public function withPermissions(): static
    {
        $this->collects::withPermissions();

        if (! \is_null($this->model)) {
            $this->appends['can'] = collect(['viewAny', 'create'])
                ->mapWithKeys(fn (string $ability) => [
                    $ability => auth()->user()->can($ability, $this->model),
                ]);
        }

        return $this;
    }
}
