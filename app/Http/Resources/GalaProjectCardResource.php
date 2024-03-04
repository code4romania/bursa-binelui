<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

class GalaProjectCardResource extends Resource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => 'project',
            'name' => $this->name,
            'slug' => $this->slug,
            'county' => $this->counties->pluck('name')->join(', '), // $this->county?->name,
            'image' => $this->getFirstMediaUrl('preview'),
            'organization' => [
                'name' => $this->organization->name,
                'slug' => $this->organization->slug,
                'id' => $this->organization->id,
            ],
        ];
    }
}
