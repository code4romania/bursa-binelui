<?php

declare(strict_types=1);

namespace App\Http\Resources\Collections;

use App\Http\Resources\TicketResource;

class ClosedTicketCollection extends ResourceCollection
{
    public $collects = TicketResource::class;

    protected array $columns = [
        'id' => [
            'label' => 'ID',
            'sortable' => true,
        ],
        'subject' => [
            'label' => 'ticket_subject',
            'sortable' => false,
        ],
        'closed_at' => [
            'label' => 'ticket_closed_at',
            'sortable' => true,
        ],
    ];
}
