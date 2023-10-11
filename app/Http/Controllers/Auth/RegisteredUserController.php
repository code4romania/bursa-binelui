<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\OrganizationStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Services\NewsletterService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'counties' => $this->getCounties(),
            'domains' => $this->getActivityDomains(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegistrationRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $user = User::create([
            'name' => $attributes['user']['name'],
            'email' => $attributes['user']['email'],
            'password' => Hash::make($attributes['user']['password']),
            'role' => $attributes['type'] === 'organization' ? UserRole::ADMIN : UserRole::USER,
        ]);

        event(new Registered($user));

        if ($user->hasRole(UserRole::ADMIN)) {
            $attributes['ngo']['status'] = OrganizationStatus::draft;

            $organization = $user->organization()->create($attributes['ngo']);

            $organization->addMediaFromRequest('ngo.logo')->toMediaCollection('logo');
            $organization->addMediaFromRequest('ngo.statute')->toMediaCollection('statute');

            $organization->activityDomains()->attach($attributes['ngo']['domains']);
            $organization->counties()->attach($attributes['ngo']['counties']);
            $user->organization_id = $organization->id;
            $user->save();
        }

        if ($attributes['subscribe']) {
            NewsletterService::subscribe($user->email, $user->name);
        }

        Auth::login($user);

        return redirect()->route('register')
            ->with('success', ['message' => 'Contul a fost creat', 'usrid' => $user['id']]);
    }

    public function update(Request $request, $userId): RedirectResponse
    {
        try {
            $user = User::find($userId);
            $user->referrer = $request->input('referrer');
            $user->save();

            return redirect()->back()
                ->with('success', 'Multumim pentru feedback');
        } catch(\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Something went wrong');
        }
    }
}
