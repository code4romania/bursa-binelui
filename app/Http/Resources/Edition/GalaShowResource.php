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
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start_date' => $this->start_date->toFormattedDate(),
            'end_date' => $this->end_date->toFormattedDate(),
            'start_sign_up' => $this->start_sign_up->toFormattedDate(),
            'end_sign_up' => $this->end_sign_up->toFormattedDate(),
            'start_validate' => $this->start_validate->toFormattedDate(),
            'end_validate' => $this->end_validate->toFormattedDate(),
            'start_evaluation' => $this->start_evaluation->toFormattedDate(),
            'end_evaluation' => $this->end_evaluation->toFormattedDate(),
            'start_gale' => $this->start_gale->toFormattedDate(),
            'location' => $this->location,
            'counties' => $this->counties->pluck('name')->join(', '),

            'registration_start_soon' => $this->start_sign_up->isFuture(),
            'registration_ended' => $this->end_sign_up->isPast(),
            'registration_is_open' => $this->registration_is_open,

            'evaluation_ended' => $this->end_evaluation->isPast(),
            'evaluation_is_open' => now()->between($this->start_evaluation, $this->end_evaluation),

            'gale_ended' => $this->start_gale->isPast(),

            'register_period' => $this->start_sign_up->toFormattedDate() . ' - ' . $this->end_sign_up->toFormattedDate(),
            'validate_period' => $this->start_validate->toFormattedDate() . ' - ' . $this->end_validate->toFormattedDate(),
            'evaluation_period' => $this->start_evaluation->toFormattedDate() . ' - ' . $this->end_evaluation->toFormattedDate(),

            'preview' => $this->getFirstMediaUrl('preview'),

        ];

        return parent::toArray($request);
    }
}
