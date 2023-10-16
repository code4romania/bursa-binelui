<?php

declare(strict_types=1);

namespace App\Http\Resources\Project;

use App\Http\Resources\Resource;
use Illuminate\Http\Request;

class EditProjectResource extends Resource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // 'type' => $this->type,
            'name' => $this->name,
            'slug' => $this->slug,

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
            'beneficiaries' => $this->beneficiaries,
            'start' => $this->start?->format('Y-m-d'),
            'end' => $this->end?->format('Y-m-d'),
            'description' => $this->description,
            'scope' => $this->scope,
            'reason_to_donate' => $this->reason_to_donate,
            'accepting_volunteers' => \boolval($this->accepting_volunteers),
            'accepting_comments' => \boolval($this->accepting_comments),
            'videos' => '',
            'external_links' => $this->external_links,
            'counties' => $this->counties->pluck('id')->toArray(),
            'counties_names' => $this->counties->pluck('name')->join(', '),
            'categories' => $this->categories->pluck('id')->toArray(),
            'categories_names' => $this->categories->pluck('name')->join(', '),
            'championship' => [
                'troffees_count' => 2,
                'score' => 100,
            ],
        ];
    }
}
