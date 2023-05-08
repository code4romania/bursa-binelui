<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use Illuminate\Http\Request;
use App\Models\Organization;

class OrganizationController extends Controller
{
    const QUERY_ACTIVITY_DOMAINS = 'ad';
    const QUERY_LOCATION = 'l';
    const QUERY_SEARCH = 's';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Organization::query();

        /** Check if we have filters by activity domains. */
        if ($request->query(self::QUERY_ACTIVITY_DOMAINS)) {
            $query->activityDomains($request->query(self::QUERY_ACTIVITY_DOMAINS, ''));
        }

        /** Check if we have filters by activity domains. */
        if ($request->query(self::QUERY_SEARCH, '')) {
            $query->search($request->query(self::QUERY_ACTIVITY_DOMAINS, ''));
        }

        // TODO: Add location;

        /** Apply the active scope. */
        $query->active();

        return $query->paginate();
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
        return $organization;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
