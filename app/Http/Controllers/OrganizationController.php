<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Filters\ActivityDomainsFilter;
use App\Http\Filters\CountiesFilter;
use App\Http\Filters\SearchFilter;
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
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Public/Organizations/Index', [
            'activity_domains' => ActivityDomain::all(['id', 'name']),
            'counties' => County::all(['id', 'name']),
            'query' => OrganizationCardsResource::collection(
                QueryBuilder::for(Organization::class)
                    ->allowedFilters([
                        AllowedFilter::custom('c', new CountiesFilter),
                        AllowedFilter::custom('ad', new ActivityDomainsFilter),
                        AllowedFilter::custom('s', new SearchFilter),
                    ])
                    ->with('activityDomains')
                    ->isApproved()
                    ->paginate()
            ),
            'filters' => $request->query('filter'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        /* Return inertia page. */
        return Inertia::render('Public/Organizations/Show', [
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

        return Inertia::render('AdminOng/Ong/EditOng', [
            'organization' => new EditOrganizationResource($organization),
            'activity_domains' => $activityDomains,
            'counties' => $counties,
            'changes' => Activity::pendingChangesFor($organization)
                ->get()
                ->flatMap(fn (Activity $activity) => $activity->properties->keys())
                ->unique()
                ->values(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        OrganizationService::update($organization, $request->validated());

        return redirect()->route('admin.ong.edit')
            ->with('success', __('organization.messages.update_success'));
    }

    public function removeLogo(Request $request)
    {
        auth()->user()->organization->clearMediaCollection('logo');

        return redirect()->back();
    }

    public function volunteer(Request $request, Organization $organization)
    {
        $attributes = $request->validate([
            'terms' => ['required', 'accepted'],
            'email' => ['required', 'email'],
            'name' => 'required',
            'phone' => 'required',
        ]);

        $volunteer = Volunteer::create([
            'user_id' => auth()->user()->id ?? null,
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'phone' => $attributes['phone'],
        ]);

        $volunteer->organizations()->attach($organization->id, ['status' => 'pending']);

        /*
         * TODO: Corner case user volunteers is redirect to VolunteerThankYou page
         *  with organization but if refreshes the page some data in thank you page is lost
         *  Posibly implementation duplicate ThankYou page and and send parameter of organization
         */
        return redirect()->route('volunteer.thanks')->with(['data' => $organization]);
    }
}
