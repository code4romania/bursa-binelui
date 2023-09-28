<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TicketMessageResource extends Resource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => $this->created_at->toDateTimeString(),
            'created_at_relative' => $this->created_at->diffForHumans(),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'is_superuser' => $this->user->isSuperUser(),
            ],
        ];
    }
}
