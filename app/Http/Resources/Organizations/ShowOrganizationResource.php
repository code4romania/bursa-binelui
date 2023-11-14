<?php

declare(strict_types=1);

namespace App\Http\Resources\Organizations;

use App\Http\Resources\ProjectCardResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowOrganizationResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'location' => $this->counties->pluck('name')->join(', '),
            'activity_domains' => $this->activityDomains->pluck('name')->join(', '),
            'logo' => $this->getFirstMediaUrl('logo', 'preview'),
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
            'projects' => ProjectCardResource::collection(
                $this->projects->map(function (Project $project) {
                    $project->setRelation('organization', $this);

                    return $project;
                })
            ),
        ];
    }
}
