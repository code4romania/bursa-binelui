<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Ticket::class, 'ticket');
    }

    public function index(string $status, Request $request): Response
    {
        return Inertia::render('AdminOng/Tickets/List', [
            'status' => $status,
            'tickets' => Ticket::query()
                ->where('organization_id', auth()->user()->organization_id)
                ->when(
                    $status === 'open',
                    fn ($query) => $query->whereOpen(),
                    fn ($query) => $query->whereClosed()
                )
                ->paginate(),
        ]);
    }


    public function show(Ticket $ticket)
    {
        $ticket->loadMissing('messages.user');

        return Inertia::render('AdminOng/Tickets/Show', [
            'ticket' => new TicketResource($ticket),
        ]);
    }
}
