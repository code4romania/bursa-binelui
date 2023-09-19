<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collections\UserCollection;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index(Request $request, ?string $status = null): Response
    {
        return Inertia::render('AdminOng/Users/Index', [
            'collection' => new UserCollection(
                QueryBuilder::for(User::class)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->allowedSorts('id', 'created_at')
                    ->defaultSorts('created_at')
                    ->paginate()
            ),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);

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

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        dd($user);

        // $user->delete();

        return redirect()->back()
            ->with('success', __('user.action_delete.success'));
    }
}
