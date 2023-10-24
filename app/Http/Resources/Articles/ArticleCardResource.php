<?php

declare(strict_types=1);

namespace App\Http\Resources\Articles;

use App\Http\Resources\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleCardResource extends Resource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'date' => $this->created_at->toFormattedDate(),
            'description' => Str::of($this->content)
                ->stripTags()
                ->limit(200),
            'author' => $this->author,
            'category' => $this->category?->only('name', 'slug'),
            'cover' => $this->getFirstMediaUrl('preview', 'large'),
        ];
    }
}
