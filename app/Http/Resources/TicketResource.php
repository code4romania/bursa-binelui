<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TicketResource extends Resource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'content' => $this->content,
            'is_open' => $this->isOpen(),
            'created_at' => $this->created_at->toFormattedDateTime(),
            'closed_at' => $this->closed_at?->toFormattedDateTime(),
            'messages' => TicketMessageResource::collection($this->whenLoaded('messages')),
        ];
    }
}
