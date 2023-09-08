<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ngo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Resources\Organizations\EditOrganizationResource;
use App\Models\Activity;
use App\Services\OrganizationService;
use Inertia\Inertia;
use Inertia\Response;

class OrganizationController extends Controller
{
    public function edit(): Response
    {
        $organization = auth()->user()->organization;

        return Inertia::render('AdminOng/Organizations/Edit', [
            'organization' => new EditOrganizationResource($organization),
            'activity_domains' => $this->getActivityDomains(),
            'counties' => $this->getCounties(),
            'changes' => Activity::pendingChangesFor($organization)
                ->get()
                ->flatMap(fn (Activity $activity) => $activity->properties->keys())
                ->unique()
                ->values(),
        ]);
    }

    public function update(UpdateOrganizationRequest $request)
    {
        $organization = auth()->user()->organization;

        $this->authorize('update', $organization);

        OrganizationService::update($organization, $request->validated());

        return redirect()->route('admin.ong.edit')
            ->with('success', __('organization.messages.update_success'));
    }
}
