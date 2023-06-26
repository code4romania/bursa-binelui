<?php

namespace App\Http\Controllers\Ngo;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VolunteerController extends Controller
{
    public function index(Request $request, $status = '')
    {

        $volunteers = Volunteer::whereHas('projects', function ($query) {
            $query->whereIn('projects.id', auth()->user()->organization->projects->pluck('id'));
        })->with('projects');
        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $volunteers->where('status', $status);
        }

        return Inertia::render('AdminOng/Volunteers/Volunteers',
            [
                'volunteers' => $volunteers->paginate()->withQueryString(),
                'status' => $status,
            ]
        );
    }

    public function approve(Request $request, $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->status = 'approved';
        $volunteer->save();
        return redirect()->back()->with('success', 'Voluntarul a fost aprobat cu succes');
    }

    public function reject(Request $request, $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->status = 'rejected';
        $volunteer->save();
        return redirect()->back()->with('success', 'Voluntarul a fost respins cu succes');
    }

public function delete(Request $request, $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $projectsIds =$request->get('project_ids',[]);
        $volunteer->projects()->detach($projectsIds);
        return redirect()->back()->with('success', 'Voluntarul a fost sters cu succes');
    }
}
