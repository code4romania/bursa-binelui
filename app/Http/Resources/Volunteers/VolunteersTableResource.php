<?php

declare(strict_types=1);

namespace App\Http\Resources\Volunteers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VolunteersTableResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at->toFormattedDateTime(),
            'name' => $this->volunteer->name,
            'email' => $this->volunteer->email,
            'phone' => $this->volunteer->phone,
            'status' => $this->status,

            'has_user' => $this->volunteer->user_id !== null,

            'project' => $this->model_type === Project::class
                ? $this->model->name
                : 'General',
        ];
    }
}
