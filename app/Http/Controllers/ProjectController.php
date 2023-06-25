<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\EuPlatescStatus;
use App\Models\County;
use App\Models\Project;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index(Request $request)
    {

        $projects = Project::publish();
        /* Check if we have filters by activity domains. */
        if ($request->query('c')) {
            $projects->whereHas('counties', function ($query) use ($request) {
                $query->whereIn('counties.id', $request->query('c'));;
            });
        }
        if ($request->query('status')) {
            $projects->whereIn('status', $request->query('status'));
        }
//        $projects->dd();
        if ($request->query('start_date')) {
            $projects->where('start', '>=', $request->query('start_date'));
        }


        if ($request->query('end_date')) {
            $projects->where('end', '<=',$request->query('end_date'));
        }

        $counties = County::get(['name', 'id']);

        return Inertia::render('Public/Projects/Projects', [
            'query' => $projects->paginate()->withQueryString(),
            'counties' => $counties,
        ]);
    }

    public function item(Project $project)
    {
        return Inertia::render('Public/Projects/Project', [
            'project' => $project,
        ]);
    }

    public function donation(Project $project, Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'terms' => 'required|accepted',
            'email' => 'required|email',
            'name' => 'required',
        ]);
        try {
            [$lastName, $firstName] = explode(' ', $request->name);
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['name' => __('invalid_name')]);
        }

        $donation = $project->donations()->create([
            'organization_id' => $project->organization_id,
            'user_id' => auth()->user()->id ?? null,
            'amount' => $request->amount,
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'charge_amount' => 0,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'status' => EuPlatescStatus::in_progress->value,
            'card_status' => null,
            'card_holder_status_message' => null,
            'approval_date'=> null,
            'charge_date' => null,
            'updated_without_correct_e_pid' => false,
        ]);

        return redirect()->route('donation.make', $donation->uuid);
    }

    public function volunteer(Project $project, Request $request)
    {
        $request->validate([
            'terms' => 'required|accepted',
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
        ]);
        try {
            [$lastName, $firstName] = explode(' ', $request->name);
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['name' => __('invalid_name')]);
        }

        Volunteer::create([
            'user_id' => auth()->user()->id ?? null,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'phone' => $request->phone,
        ])->projects()->attach($project->id);
        return redirect()->back()->with('success', __('success_volunteer'));
    }
}
