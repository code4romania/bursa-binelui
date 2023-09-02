<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Vite;

class BCRProjectCardsResource extends JsonResource
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

            'is_active' => $this->is_active,
            'is_ending_soon' => $this->is_ending_soon,
        ];
    }
}
