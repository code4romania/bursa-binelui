<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ProjectResource extends Resource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
//        dd($this);

        return [
            'id' => $this->id,
            // 'type' => $this->type,
            'name' => $this->name,
            'slug' => $this->slug,
            'county' => $this->counties->pluck('name')->join(', '),
            'image' => $this->getFirstMediaUrl('preview'),
            'target_budget' => $this->target_budget,
            'gallery' => $this->getMedia('gallery')->map(function ($media) {
                return [
                    'id' => $media->id,
                    'url' => $media->getFullUrl(),
                ];
            })->toArray(),
            'organization' => [
                'name' => $this->organization->name,
                'id' => $this->organization->id,
            ],
            'is_national' => \boolval($this->is_national),
            'start' => $this->start,
            'end' => $this->end,
            'description' => $this->description,
            'scope' => $this->scope,
            'reason_to_donate' => $this->reason_to_donate,
            'accepting_volunteers' => \boolval($this->accepting_volunteers),
            'accepting_comments' => \boolval($this->accepting_comments),
            'videos' => $this->videos,
            'external_links' => $this->external_links,
            'categories' => $this->categories->pluck('name')->join(', '),
            'championship' => [
                'troffees_count' => 2,
                'score' => 100,
            ],
        ];
    }
}
