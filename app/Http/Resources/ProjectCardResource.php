<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ProjectCardResource extends Resource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // 'type' => $this->type,
            'name' => $this->name,
            'slug' => $this->slug,
            'county' => 'Replace me', // $this->county?->name,
            'image' => $this->getFirstMediaUrl('cover_image'),
            'organization' => [
                'name' => $this->organization->name,
                'id' => $this->organization->id,
            ],
            'categories' => $this->categories->pluck('name')->join(', '),
            'donations' => [
                'target' => money_format($this->target_budget),
                'total' => money_format($this->total_donations),
                'percentage' => $this->percentage,
            ],
            'is_active' => $this->is_active,
            'is_ending_soon' => $this->is_ending_soon,
            'championship' => [
                'troffees_count' => 2,
                'score' => 100,
            ],
        ];
    }
}
