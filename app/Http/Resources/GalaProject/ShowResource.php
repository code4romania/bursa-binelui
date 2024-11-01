<?php

declare(strict_types=1);

namespace App\Http\Resources\GalaProject;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [

            'organization' => [
                'name' => $this->organization->name,
                'id' => $this->organization->id,
            ],
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'areas' => $this->area,
            'youth' => $this->youth ? __('field.boolean.true') : __('field.boolean.false'),
            'organization_type' => $this->organization_type->label(),
            'reason' => $this->reason,
            'solution' => $this->solution,
            'project_details' => $this->project_details,
            'special' => $this->special,
            'is_draft' => $this->isDraft(),
            'results' => $this->results,
            'proud' => $this->proud,
            'partnership' => $this->partnership ? __('field.boolean.true') : __('field.boolean.false'),
            'partnership_details' => $this->partnership_details,
            'budget_details' => $this->budget_details,
            'participants' => $this->participants,
            'team_details' => $this->team_details,
            'contact' => $this->contact,
            'status' => $this->status->label(),
            'eligible' => $this->eligible ? __('field.boolean.true') : __('field.boolean.false'),
            'short_list' => $this->short_list ? __('field.boolean.true') : __('field.boolean.false'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
