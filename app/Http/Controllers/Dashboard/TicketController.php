<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collections\ClosedTicketCollection;
use App\Http\Resources\Collections\OpenTicketCollection;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\QueryBuilder;

class TicketController extends Controller
{
    public function index(Request $request, ?string $status = null): Response|RedirectResponse
    {
        if (! $status) {
            return redirect()->route('dashboard.tickets.index', 'open');
        }

        if ($status === 'open') {
            $collection = new OpenTicketCollection(
                QueryBuilder::for(Ticket::class)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->whereOpen()
                    ->allowedSorts('id', 'created_at')
                    ->defaultSorts('created_at')
                    ->paginate()
            );
        } else {
            $collection = new ClosedTicketCollection(
                QueryBuilder::for(Ticket::class)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->whereClosed()
                    ->allowedSorts('id', 'closed_at')
                    ->defaultSorts('closed_at')
                    ->paginate()
            );
        }

        return Inertia::render('AdminOng/Tickets/Index', [
            'status' => $status,
            'collection' => $collection,
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

        return redirect()->route('dashboard.tickets.view', $ticket)
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

        return redirect()->route('dashboard.tickets.view', $ticket)
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

        return redirect()->route('dashboard.tickets.view', $ticket)
            ->with('success', $message);
    }
}
