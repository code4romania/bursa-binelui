<?php

declare(strict_types=1);

namespace App\Http\Resources\Edition;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalaShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'start_sign_up' => $this->start_sign_up,
            'end_sign_up' => $this->end_sign_up,
            'start_validate' => $this->start_validate,
            'end_validate' => $this->end_validate,
            'start_evaluation' => $this->start_evaluation,
            'end_evaluation' => $this->end_evaluation,
            'start_gale' => $this->start_gale,
            'location' => $this->location,
            'counties' => $this->counties->pluck('name')->join(', '),
            'registration_is_open' => $this->registration_is_open,
        ];

        return parent::toArray($request);
    }
}
