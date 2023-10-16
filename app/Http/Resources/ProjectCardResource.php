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
            'image' => $this->getFirstMediaUrl('preview'),
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
            'is_pending' => $this->is_pending,
            'is_ending_soon' => $this->is_ending_soon,
            'is_draft' => $this->is_draft,
            'can_be_archived' => $this->can_be_archived,
            'championship' => [
                'troffees_count' => 2,
                'score' => 100,
            ],
        ];
    }
}
