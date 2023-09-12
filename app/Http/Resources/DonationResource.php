<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'donor' => "{$this->first_name} {$this->last_name}",
            'project' => $this->project->name,
            'amount' => money_format($this->amount),
            'status' => $this->status,
            'created_at' => $this->created_at->toFormattedDateTime(),
        ];
    }
}
