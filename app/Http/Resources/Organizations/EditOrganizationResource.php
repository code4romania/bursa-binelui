<?php

declare(strict_types=1);

namespace App\Http\Resources\Organizations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditOrganizationResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cif' => $this->cif,
            'counties' => $this->counties->pluck('id'),
            'county_names' => $this->counties->pluck('name'),
            'activity_domains' => $this->activityDomains->pluck('id'),
            'activity_domain_names' => $this->activityDomains->pluck('name'),
            'logo' => $this->getFirstMediaUrl('logo', 'preview'),
            'statute_link' => $this->getFirstMediaUrl('statute'),
            'description' => $this->description,
            'address' => $this->address,
            'contact_person' => $this->contact_person,
            'contact_phone' => $this->contact_phone,
            'contact_email' => $this->contact_email,
            'website' => $this->website,
            'accepts_volunteers' => $this->accepts_volunteers,
            'why_volunteer' => $this->why_volunteer,
            'status' => $this->status,
            'eu_platesc_merchant_id' => filled($this->eu_platesc_merchant_id),
            'eu_platesc_private_key' => filled($this->eu_platesc_private_key),
        ];
    }
}
