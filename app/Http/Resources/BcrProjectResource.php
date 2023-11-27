<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcrProjectResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'county' => $this?->county?->name,
            'image' => $this->getFirstMediaUrl('preview'),
            'gallery' => $this->getMedia('gallery')->map(function ($media) {
                return [
                    'id' => $media->id,
                    'url' => $media->getFullUrl(),
                ];
            })->toArray(),
            'is_national' => \boolval($this->is_national),
            'area' => $this->is_national ? __('bcr-project.labels.national') : $this?->county?->name,
            'start' => $this->start_date?->format('d.m.Y'),
            'end' => $this->end_date?->format('d.m.Y'),
            'description' => $this->description,
            'accepting_comments' => \boolval($this->accepting_comments),
            'embedded_videos' => $this->embedded_videos,
            'swipe_gallery' => $this->getMedia('gallery')->map(function ($media) {
                return [
                    'src' => $media->getFullUrl(),
                    'thumbnail' => $media->getFullUrl('preview'),
                    'w' => 1200,
                    'h' => 800,
                ];
            })->toArray(),
            'external_links' => collect($this->external_links)->map(function (array $link) {
                $link['source'] = parse_url($link['link'], \PHP_URL_HOST);

                return $link;
            }),
            'category' => $this->category->name,
        ];
    }
}
