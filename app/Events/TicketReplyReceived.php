<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\TicketMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketReplyReceived
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public TicketMessage $message;

    /**
     * Create a new event instance.
     */
    public function __construct(TicketMessage $message)
    {
        $this->message = $message;
    }
}
