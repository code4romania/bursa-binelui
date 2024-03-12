<?php

declare(strict_types=1);

namespace App\Http\Resources\Edition;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditionShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [

            'title' => $this->title,
            'short_description' => $this->short_description,
            'page_rules' => $this->page->slug,
            'start' => $this->start_date,
            'end' => $this->end_date,
            'gales' => GalaShowResource::collection($this->gales),

        ];
    }
}
