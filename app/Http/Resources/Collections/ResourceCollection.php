<?php

declare(strict_types=1);

namespace App\Http\Resources\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection as BaseCollection;
use Illuminate\Support\Str;

abstract class ResourceCollection extends BaseCollection
{
    protected array $columns = [];

    public function toArray(Request $request): array
    {
        return [
            'columns' => $this->getColumns(),
            'filter' => $request->query('filter'),
            'sort' => $this->getSort($request),
            'data' => $this->collection,
        ];
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
}
