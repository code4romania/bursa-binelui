<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

class OrganizationCardsResource extends Resource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'logo' => $this->getFirstMediaUrl('logo'),
            'activity_domains' => $this->activityDomains->pluck('name')->join(', '),
        ];
    }
}
