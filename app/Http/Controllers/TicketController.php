<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    public function index(string $status, Request $request): Response
    {
        return Inertia::render('AdminOng/Tickets/List', [
            'status' => $status,
            'tickets' => TicketResource::collection(
                Ticket::query()
                    ->where('organization_id', auth()->user()->organization_id)
                    ->when(
                        $status === 'open',
                        fn ($query) => $query->whereOpen(),
                        fn ($query) => $query->whereClosed()
                    )
                    ->orderBy('closed_at', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get()
            ),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Ticket::class);

        $attributes = $request->validate([
            'subject' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string'],
        ]);

        $ticket = Ticket::create([
            'subject' => strip_tags($attributes['subject']),
            'content' => strip_tags($attributes['content']),
            'user_id' => auth()->user()->id,
            'organization_id' => auth()->user()->organization_id,
        ]);

        return redirect()->route('admin.ong.tickets.view', $ticket)
            ->with('success', __('ticket.action_open.success'));
    }

    public function reply(Ticket $ticket, Request $request): RedirectResponse
    {
        $this->authorize('reply', $ticket);

        $attributes = $request->validate([
            'content' => ['required', 'string'],
        ]);

        $ticket->messages()->create([
            'user_id' => auth()->user()->id,
            'content' => strip_tags($attributes['content']),
        ]);

        return redirect()->route('admin.ong.tickets.view', $ticket)
            ->with('success', __('ticket.action_reply.success'));
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->loadMissing('messages.user');

        return Inertia::render('AdminOng/Tickets/Show', [
            'ticket' => new TicketResource($ticket),
        ]);
    }

    public function status(Ticket $ticket, Request $request): RedirectResponse
    {
        $this->authorize('update', $ticket);

        if ($ticket->isOpen()) {
            $ticket->close();
            $message = __('ticket.action_close_confirm.success');
        } else {
            $ticket->open();
            $message = __('ticket.action_reopen_confirm.success');
        }

        return redirect()->route('admin.ong.tickets.view', $ticket)
            ->with('success', $message);
    }
}
