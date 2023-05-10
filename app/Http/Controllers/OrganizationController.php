<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use Illuminate\Http\Request;
use App\Enums\OrganizationQuery;
use App\Enums\OrganizationStatus;
use App\Models\Organization;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Organization::query();

        /** Check if we have filters by activity domains. */
        if ($request->query(OrganizationQuery::activity_domain->value)) {
            $query->activityDomains($request->query(OrganizationQuery::activity_domain->value, ''));
        }

        /** Check if we have filters by cities. */
        if ($request->query(OrganizationQuery::cities->value, '')) {
            $query->cities($request->query(OrganizationQuery::cities->value, ''));
        }

        /** Check if we have a search. */
        if ($request->query(OrganizationQuery::search->value, '')) {
            $query->search($request->query(OrganizationQuery::search->value, ''));
        }

        /** Apply the active scope. */
        $query->status(OrganizationStatus::active);

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