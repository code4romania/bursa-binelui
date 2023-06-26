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
}
