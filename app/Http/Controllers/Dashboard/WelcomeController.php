<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class WelcomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function (Request $request, Closure $next) {
            abort_unless(
                $request->hasValidSignature(),
                Response::HTTP_FORBIDDEN,
                __('auth.welcome.invalid_signature')
            );

            abort_unless(
                $request->user,
                Response::HTTP_FORBIDDEN,
                __('auth.welcome.no_user')
            );

            abort_if(
                $request->user->hasSetPassword(),
                Response::HTTP_FORBIDDEN,
                __('auth.welcome.already_used')
            );

            return $next($request);
        });
    }

    public function create(Request $request, User $user): InertiaResponse
    {
        return Inertia::render('Auth/Welcome', [
            'email' => $user->email,
        ]);
    }

    public function store(Request $request, User $user): RedirectResponse
    {
        $attributes = $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->setPassword($attributes['password']);

        return redirect()->route('login')
            ->with('success', __('user.messages.set_initial_password_success'));
    }
}
