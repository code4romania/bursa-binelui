<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Vite;

class ProjectCardsResource extends JsonResource
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
            'image' => Vite::asset('resources/images/placeholder.png'),
            'organization' => [
                'name' => $this->organization->name,
                'id' => $this->organization->id,
            ],
            'activity_domains' => 'Replace me', // $this->activityDomains->pluck('name')->join(', '),
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
