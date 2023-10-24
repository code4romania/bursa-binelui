<?php

declare(strict_types=1);

namespace App\Http\Resources\Collections;

use App\Http\Resources\BCRProjectCardResource;
use App\Http\Resources\ProjectCardResource;

class BcrProjectCardCollection extends ResourceCollection
{
    public $collects = BCRProjectCardResource::class;

    protected function getColumns(): array
    {
        return [

        ];
    }
}
