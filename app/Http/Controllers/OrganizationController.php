<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Filters\ActivityDomainsFilter;
use App\Http\Filters\CountiesFilter;
use App\Http\Filters\SearchFilter;
use App\Http\Resources\OrganizationCardsResource;
use App\Http\Resources\Organizations\ShowOrganizationResource;
use App\Models\Organization;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Public/Organizations/Index', [
            'filter' => $request->query('filter'),
            'domains' => $this->getActivityDomains(),
            'counties' => $this->getCounties(),
            'resource' => OrganizationCardsResource::collection(
                QueryBuilder::for(Organization::class)
                    ->allowedFilters([
                        AllowedFilter::custom('county', new CountiesFilter),
                        AllowedFilter::custom('domain', new ActivityDomainsFilter),
                        AllowedFilter::custom('search', new SearchFilter),
                    ])
                    ->with('activityDomains')
                    ->isApproved()
                    ->paginate()
            ),
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
