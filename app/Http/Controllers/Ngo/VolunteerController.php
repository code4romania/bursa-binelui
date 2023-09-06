<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ngo;

use App\Enums\VolunteerStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Volunteers\VolunteersTableResource;
use App\Models\VolunteerRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VolunteerController extends Controller
{
    public function index(Request $request, string $status = '')
    {
        if (auth()->user()->organization == null) {
            return redirect()->route('admin.ong.edit');
        }

        $status = VolunteerStatus::tryFrom($status) ?? VolunteerStatus::APPROVED;

        return Inertia::render('AdminOng/Volunteers/Volunteers', [
            'volunteers' => VolunteersTableResource::collection(
                VolunteerRequest::query()
                    ->with('volunteer')
                    ->whereBelongsToOrganization(auth()->user()->organization->id)
                    ->where('status', $status)
                    ->orderBy('created_at', 'desc')
                    ->paginate(15)
                    ->withQueryString()
            ),
            'status' => $status,
        ]);
    }

    public function approve(Request $request, VolunteerRequest $volunteerRequest)
    {
        $volunteerRequest->markAsApproved();

        return redirect()->back()
            ->with('success', 'Voluntarul a fost aprobat cu succes');
    }

    public function reject(Request $request, VolunteerRequest $volunteerRequest)
    {
        $volunteerRequest->markAsRejected();

        return redirect()->back()
            ->with('success', 'Voluntarul a fost respins cu succes');
    }

    public function delete(Request $request, VolunteerRequest $volunteerRequest)
    {
        $volunteerRequest->delete();

        return redirect()->back()
            ->with('success', 'Voluntarul a fost sters cu succes');
    }
}
