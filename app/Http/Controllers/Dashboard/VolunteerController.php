<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Enums\VolunteerStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Collections\VolunteerCollection;
use App\Models\VolunteerRequest;
use App\Notifications\UserWasApprovedForVolunteering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class VolunteerController extends Controller
{
    public function index(Request $request, string $status = '')
    {
        if (auth()->user()->organization === null) {
            return redirect()->route('dashboard.organization.edit');
        }

        $status = VolunteerStatus::tryFrom($status) ?? VolunteerStatus::APPROVED;

        return Inertia::render('AdminOng/Volunteers/Index', [
            'status' => $status,
            'collection' => new VolunteerCollection(
                QueryBuilder::for(VolunteerRequest::class)
                    ->with('volunteer')
                    ->whereBelongsToOrganization(auth()->user()->organization->id)
                    ->where('status', $status)
                    ->allowedSorts('id', 'created_at', 'name')
                    ->defaultSorts('-created_at')
                    ->paginate()
                    ->withQueryString()
            ),
        ]);
    }

    public function approve(Request $request, VolunteerRequest $volunteerRequest)
    {
        $this->authorize('update', $volunteerRequest);

        $volunteerRequest->markAsApproved();

        Notification::route('mail', $volunteerRequest->volunteer->email)
            ->notify(new UserWasApprovedForVolunteering);

        return redirect()->back()
            ->with('success', __('volunteer.messages.approved'));
    }

    public function reject(Request $request, VolunteerRequest $volunteerRequest)
    {
        $this->authorize('update', $volunteerRequest);
        $volunteerRequest->markAsRejected();

        return redirect()->back()
            ->with('success', __('volunteer.messages.rejected'));
    }

    public function delete(Request $request, VolunteerRequest $volunteerRequest)
    {
        $this->authorize('delete', $volunteerRequest);
        $volunteerRequest->delete();

        return redirect()->back()
            ->with('success', __('volunteer.messages.deleted'));
    }
}
