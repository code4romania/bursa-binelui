<?php

declare(strict_types=1);

namespace App\Http\Resources\Collections;

use App\Http\Resources\TicketResource;

class OpenTicketCollection extends ResourceCollection
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
        'created_at' => [
            'label' => 'ticket_created_at',
            'sortable' => true,
        ],
    ];
}
