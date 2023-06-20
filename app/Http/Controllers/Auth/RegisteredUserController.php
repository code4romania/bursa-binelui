<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\ActivityDomain;
use App\Models\Organization;
use App\Models\User;
use App\Notifications\Admin\OrganizationCreated as OrganizationCreatedAdmin;
use App\Notifications\Ngo\OrganizationCreated;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $activityDomains = cache()->remember('activityDomains', 60 * 60 * 24, function () {
            return ActivityDomain::get(['name', 'id']);
        });
        $counties = cache()->remember('counties', 60 * 60 * 24, function () {
            return \App\Models\County::get(['name', 'id']);
        });

        return Inertia::render(
            'Auth/Register',
            [
                'activity_domains' => $activityDomains,
                'counties' => $counties,
            ]
        );
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegistrationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $data['user'];

        $user = User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
        ]);
        event(new Registered($user));
        // Auth::login($user);

        if ($data['type'] == 'ong') {
            $ong = $data['ong'];
            $organization = Organization::create($ong);
            $organization->activityDomains()->attach($ong['activity_domains_ids']);
            $organization->counties()->attach($ong['counties_ids']);
            $adminUsers = User::whereRole(UserRole::bb_admin)->get();
            Notification::send($adminUsers, new OrganizationCreatedAdmin($organization));
            Notification::send($user, new OrganizationCreated($organization));
            $user->organization_id = $organization->id;
            $user->save();
        }
        return Redirect::route('register');
    }

    public function update(RegistrationRequest $request): RedirectResponse
    {

    }
}
