<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\OrganizationQuery;
use App\Enums\OrganizationStatus;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Resources\OrganizationCardsResource;
use App\Http\Resources\Organizations\EditOrganizationResource;
use App\Http\Resources\Organizations\ShowOrganizationResource;
use App\Models\Activity;
use App\Models\ActivityDomain;
use App\Models\County;
use App\Models\Organization;
use App\Models\Volunteer;
use App\Services\OrganizationService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Organization::query()
            ->with('activityDomains');

        /* Check if we have filters by activity domains. */
        if ($request->query(OrganizationQuery::activity_domain->value)) {
            $query->whereHas('activityDomains', function ($query) use ($request) {
                $query->whereIn('activity_domains.id', $request->query(OrganizationQuery::activity_domain->value));
            });
        }

        if ($request->query(OrganizationQuery::counties->value)) {
            $query->whereHas('counties', function ($query) use ($request) {
                $query->whereIn('counties.id', $request->query(OrganizationQuery::counties->value));
            });
        }
        /* Check if we have a search. */
        if ($request->query(OrganizationQuery::search->value, '')) {
            $query->search($request->query(OrganizationQuery::search->value, ''));
        }
        /* Apply the active scope. */
        $query->status(OrganizationStatus::approved);

        /* Extract existing organizations cities with county. */
        /* Return inertia page. */
        return Inertia::render('Public/Organizations/Organizations', [
            'activity_domains' => ActivityDomain::all(),
            'counties' => \App\Models\County::all(),
            'query' => OrganizationCardsResource::collection(
                $query->paginate()
            ),
            'request' => $request,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        /* Return inertia page. */
        return Inertia::render('Public/Organizations/Organization', [
            'organization' => new ShowOrganizationResource(
                $organization->loadMissing([
                    'activityDomains',
                    'counties',
                    'projects' => fn ($query) => $query->wherePublished(),
                ]),
            ),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $organization = auth()->user()->organization;

        $activityDomains = cache()->remember('activityDomains', 60 * 60 * 24, function () {
            return ActivityDomain::get(['name', 'id']);
        });

        $counties = cache()->remember('counties', 60 * 60 * 24, function () {
            return County::get(['name', 'id']);
        });

        $changes = Activity::pendingChangesFor($organization)
            ->get()
            ->flatMap(fn (Activity $activity) => $activity->properties->keys())
            ->unique()
            ->values();

        return Inertia::render('AdminOng/Ong/EditOng', [
            'organization' => new EditOrganizationResource($organization),
            'activity_domains' => $activityDomains,
            'counties' => $counties,
            'changes' => $changes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        OrganizationService::update($organization, $request->validated());

        return redirect()->route('admin.ong.edit')
            ->with('success_message', __('organization.messages.update_success'));
    }

    public function removeLogo(Request $request)
    {
        auth()->user()->organization->clearMediaCollection('logo');

        return redirect()->back();
    }

    public function volunteer(Organization $organization, Request $request)
    {
        $request->validate([
            'terms' => 'required|accepted',
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
        ]);
        try {
            $name = explode(' ', $request->name);

            if (\is_array($name) && ! empty($name)) {
                $lastName = $name[0] ? $name[0] : '';
                $firstName = (1 < \count($name)) ? implode(' ', \array_slice($name, 1)) : '';
            }
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['name' => __('invalid_name')]);
        }

        Volunteer::create([
            'user_id' => auth()->user()->id ?? null,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'phone' => $request->phone,
        ])->organizations()->attach($organization->id);

        /*
         * TODO: Corner case user volunteers is redirect to VolunteerThankYou page
         *  with organization but if refreshes the page some data in thank you page is lost
         *  Posibly implementation duplicate ThankYou page and and send parameter of organization
         */
        return redirect()->route('volunteer.thanks')->with(['data' => $organization]);
    }
}
