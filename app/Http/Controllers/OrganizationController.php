<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\OrganizationQuery;
use App\Enums\OrganizationStatus;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Requests\StoreOrganizationRequest;
use App\Models\ActivityDomain;
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

//        /* Check if we have filters by activity domains. */
//        if ($request->query(OrganizationQuery::activity_domain->value)) {
//            $query->activityDomains($request->query(OrganizationQuery::activity_domain->value, ''));
//        }
        /* Check if we have a search. */
        if ($request->query(OrganizationQuery::search->value, '')) {
            $query->search($request->query(OrganizationQuery::search->value, ''));
        }

        /* Apply the active scope. */
        $query->status(OrganizationStatus::active);

        /** Extract existing organizations cities with county. */
        /* Return inertia page. */
        return Inertia::render('Public/Organizations/Organizations', [
            'activity_domains' => ActivityDomain::all(),
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
    public function edit()
    {
        $organization = auth()->user()->organization;
        $activityDomains = cache()->remember('activityDomains', 60 * 60 * 24, function () {
            return \App\Models\ActivityDomain::get(['name', 'id']);
        });
        $counties = cache()->remember('counties', 60 * 60 * 24, function () {
            return \App\Models\County::get(['name', 'id']);
        });

        return Inertia::render('AdminOng/Ong/EditOng', [
            'organization' => $organization,
            'activity_domains' => $activityDomains,
            'counties' => $counties,
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
            if ($request->hasFile('activity_domains')) {
                $organization->activityDomains()->sync($request->input('activity_domains'));
            }

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
