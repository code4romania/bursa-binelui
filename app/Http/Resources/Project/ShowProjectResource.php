<?php

declare(strict_types=1);

namespace App\Http\Resources\Project;

use App\Http\Resources\Resource;
use Illuminate\Http\Request;

class ShowProjectResource extends Resource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'counties' => $this->counties->pluck('name')->join(', '),
            'status' => $this->visible_status,
            'image' => $this->getFirstMediaUrl('preview'),
            'target_budget' => $this->target_budget,
            'gallery' => $this->getMedia('gallery')->map(function ($media) {
                return [
                    'id' => $media->id,
                    'url' => $media->getFullUrl(),
                ];
            })->toArray(),
            'organization' => [
                'id' => $this->organization->id,
                'name' => $this->organization->name,
                'description' => $this->organization->description,
                'logo' => $this->organization->getFirstMediaUrl('logo', 'preview'),
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
            'is_active' => $this->is_active,
            'external_links' => collect($this->external_links)->map(function (array $link) {
                $link['source'] = parse_url($link['url'], \PHP_URL_HOST);

                return $link;
            }),
            'categories' => $this->categories->pluck('name')->join(', '),
            'donations' => [
                'target' => money_format($this->target_budget),
                'total' => money_format($this->total_donations),
                'percentage' => $this->percentage,
            ],
            'championship' => [
                'troffees_count' => 2,
                'score' => 100,
            ],
        ];
    }
}
