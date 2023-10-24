<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;

class BCRProjectCardResource extends Resource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => 'bcr_project',
            'name' => $this->name,
            'slug' => $this->slug,
            'county' => $this->county?->name,
            'image' => $this->getFirstMediaUrl('preview') ?? Vite::image('placeholder.png'),
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'facebook_link' => $this->facebook_link,
            'is_national' => $this->is_national,
            'accepting_comments' => $this->accepting_comments,
            'videos' => $this->videos,
            'external_links' => $this->external_links,

        ];
    }
}
