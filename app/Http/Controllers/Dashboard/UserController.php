<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collections\UserCollection;
use App\Models\User;
use App\Rules\UserDoesntBelongToAnOrganization;
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
            'collection' => UserCollection::make(
                QueryBuilder::for(User::class)
                    ->with('organization:id')
                    ->where('organization_id', auth()->user()->organization_id)
                    ->allowedSorts('name', 'email', 'created_at')
                    ->defaultSorts('created_at')
                    ->paginate(),
            )->withPermissions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'email', new UserDoesntBelongToAnOrganization],
        ]);

        $user = User::firstOrNew(
            ['email' => $attributes['email']],
            [
                'name' => $attributes['name'],
                'created_by' => auth()->user()->id,
            ]
        );

        $user->organization()
            ->associate(auth()->user()->organization)
            ->save();

        return redirect()->back()
            ->with('success', __('user.messages.created'));
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->organization()
            ->dissociate()
            ->save();

        return redirect()->back()
            ->with('success', __('user.messages.deleted'));
    }
}
