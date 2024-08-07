<?php

declare(strict_types=1);

namespace App\Http\Resources\Project;

use App\Http\Resources\Resource;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EditProjectResource extends Resource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,

            'image' => $this->getFirstMediaUrl('preview'),
            'target_budget' => $this->target_budget,
            'gallery' => $this->getMedia('gallery')->map(function (Media $media) {
                return [
                    'id' => $media->id,
                    'url' => $media->getFullUrl('preview'),
                ];
            })->toArray(),
            'organization' => [
                'name' => $this->organization->name,
                'id' => $this->organization->id,
            ],
            'beneficiaries' => $this->beneficiaries ?? '',
            'start' => $this->start?->format('Y-m-d'),
            'end' => $this->end?->format('Y-m-d'),
            'description' => $this->description ?? '',
            'scope' => $this->scope ?? '',
            'reason_to_donate' => $this->reason_to_donate ?? '',
            'accepting_volunteers' => $this->accepting_volunteers ? __('field.boolean.true') : __('field.boolean.false'),
            'accepting_comments' => $this->accepting_comments ? __('field.boolean.true') : __('field.boolean.false'),
            'is_national' => $this->is_national ? __('field.boolean.true') : __('field.boolean.false'),
            'videos' => empty($this->videos) ? [] : $this->videos,
            'external_links' => empty($this->external_links) ? [] : $this->external_links,
            'counties' => $this->counties->pluck('id')->toArray(),
            'counties_names' => $this->counties->pluck('name')->join(', '),
            'categories' => $this->categories->pluck('id')->toArray(),
            'categories_names' => $this->categories->pluck('name')->join(', '),
            'championship' => [
                'troffees_count' => 2,
                'score' => 100,
            ],
            'active' => $this->active,
            'is_active' => $this->is_active,
            'is_pending' => $this->is_pending,
            'can_be_archived' => $this->can_be_archived,
        ];
    }
}
