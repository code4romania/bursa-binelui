<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back();
    }

    public function setInitialPassword(User $user, Request $request): \Inertia\Response
    {
        if (! $request->hasValidSignature()) {
            abort(Response::HTTP_FORBIDDEN, __('auth.welcome.invalid_signature'));
        }

        if (\is_null($user)) {
            abort(Response::HTTP_FORBIDDEN, __('auth.welcome.no_user'));
        }

        if ($user->hasSetPassword()) {
            abort(Response::HTTP_FORBIDDEN, __('auth.welcome.already_used'));
        }

        return Inertia::render('Auth/SetInitialPassword', [
            'user' => $user,
            'token' => sha1($user->email),
        ]);
    }

    public function storeInitialPassword(Request $request, User $user): RedirectResponse
    {
        if ($request->token !== sha1($user->email)) {
            abort(401);
        }
        $validated = $request->validate([
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
        $user->markPasswordAsSet();

        return redirect()->route('login')->with('success_message', __('user.messages.set_initial_password_success'));
    }
}
