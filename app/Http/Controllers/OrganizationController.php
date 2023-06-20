<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ActivityDomain;
use App\Enums\OrganizationQuery;
use App\Enums\OrganizationStatus;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Requests\StoreOrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Organization::query();

        /* Check if we have filters by activity domains. */
        if ($request->query(OrganizationQuery::activity_domain->value)) {
            $query->activityDomains($request->query(OrganizationQuery::activity_domain->value, ''));
        }

        /* Check if we have filters by cities. */
        if ($request->query(OrganizationQuery::cities->value, '')) {
            $query->cities($request->query(OrganizationQuery::cities->value, ''));
        }

        /* Check if we have a search. */
        if ($request->query(OrganizationQuery::search->value, '')) {
            $query->search($request->query(OrganizationQuery::search->value, ''));
        }

        /* Apply the active scope. */
        $query->status(OrganizationStatus::active);

        /** Extract existing organizations cities with county. */
        $cities = $query->with('city.county')->get()->map(function (Organization $organization) {
            return [
                'id' => $organization->city_id,
                'name' => $organization->city->name_with_county,
            ];
        });

        /* Return inertia page. */
        return Inertia::render('Public/Organizations/Organizations', [
            'activity_domains' => ActivityDomain::cases(),
            'cities' => $cities,
            'query' => $query->paginate(),
            'request' => $request,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        /* Add organization city name. */
        $organization->city_name = $organization->city->name;
        /* Add organization county name. */
        $organization->county_name = $organization->county->name;

        /* Return inertia page. */
        return Inertia::render('Public/Organizations/Organization', [
            'organization' => $organization,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        return Inertia::render('AdminOng/Ong/EditOng', [
            'organization' => $organization,
            'activity_domains' => ActivityDomain::cases(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        try {
            /** Get all request data. */
            $modelData = $request->input();

            $organization->update($modelData);

            return redirect()->route('admin.ong.edit', [$organization])->with('success_message', 'Organization updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('admin.ong.edit', [$organization])->with('error_message', 'Organization update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
