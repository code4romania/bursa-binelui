<?php

declare(strict_types=1);

namespace App\Http\Resources\Collections;

use App\Http\Resources\ProjectCardResource;

class ProjectCardCollection extends ResourceCollection
{
    public $collects = ProjectCardResource::class;

    protected function getColumns(): array
    {
        return [

        ];
    }
}
