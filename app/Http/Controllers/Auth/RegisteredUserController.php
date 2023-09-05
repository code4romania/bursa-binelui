<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\OrganizationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\ActivityDomain;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

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
        try {
            $data = $request->validated();
            $user = $data['user'];

            $user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'role' => $data['type'],
            ]);
            event(new Registered($user));

            if ($data['type'] == 'ngo-admin') {
                $ong = $data['ong'];
                $ong['status'] = OrganizationStatus::draft;
                $organization = Organization::create($ong);
                $organization->addMediaFromRequest('ong.logo')->toMediaCollection('logo');
                if ($request->hasFile('ong.statute')) {
                    $organization->addMediaFromRequest('ong.statute')->toMediaCollection('statute');
                }
                $organization->activityDomains()->attach($ong['activity_domains_ids']);
                $organization->counties()->attach($ong['counties_ids']);
                $user->organization_id = $organization->id;
                $user->save();
            }
            Auth::login($user);

            return redirect()->route('register')->with('success_message', ['message' => 'Contul a fost creat', 'usrid' => $user['id']]);
        } catch(\Throwable $th) {
            Log::log('error', $th->getMessage());

            return redirect()->back()->with('error_message', __('auth.failed'));
        }
    }

    public function update(Request $request, $userId): RedirectResponse
    {
        try {
            $user = User::find($userId);
            $user->source_of_information = $request->input('source_of_information');
            $user->save();

            return redirect()->back()->with('success_message', 'Multumim pentru feedback');
        } catch(\Throwable $th) {
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }
}
