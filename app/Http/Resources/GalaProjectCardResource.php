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
            'type' => 'gala_project',
            'name' => $this->name,
            'slug' => $this->slug,
            'counties' => $this->counties->pluck('name')->join(', '), // $this->county?->name,
            'counties_count' => $this->counties->count(),
            'image' => $this->getFirstMediaUrl('regionalProjectFiles'),
            'organization' => [
                'name' => $this->organization->name,
                'slug' => $this->organization->slug,
                'id' => $this->organization->id,
            ],
            'categories' => $this->categories->pluck('name')->join(', '),
            'is_draft' => $this->isDraft(),

        ];
    }
}
