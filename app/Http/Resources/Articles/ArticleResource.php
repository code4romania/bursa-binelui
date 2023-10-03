<?php

declare(strict_types=1);

namespace App\Http\Resources\Articles;

use App\Http\Resources\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ArticleResource extends Resource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => Str::of($this->content)
                ->stripTags()
                ->limit(200),
            'content' => $this->content,
            'author' => $this->author,
            'category' => $this->category?->name,
            'cover' => $this->getFirstMediaUrl('cover', 'large'),
            'gallery' => $this->getMedia('gallery')->map(fn (Media $media) => $media->getUrl('large')),
        ];
    }
}
