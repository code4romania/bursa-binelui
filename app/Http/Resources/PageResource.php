<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PageResource extends Resource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
        ];
    }
}
