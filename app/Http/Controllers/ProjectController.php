<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\EuPlatescStatus;
use App\Models\ActivityDomain;
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
                $query->whereIn('counties.id', $request->query('c'));
            });
        }
        if ($request->query('status')) {
            $projects->whereIn('status', $request->query('status'));
        }

        if ($request->query('category')) {
            $projects->whereIn('category', $request->query('category'));
        }

        /* For this wee need to sent to front the small start and biggest end */
        if ($request->query('date')) {
            $date = explode('-', $request->query('date'));
            $projects->where('start', '>=', str_replace('.', '-', $date[0]));
            $projects->where('end', '<=', str_replace('.', '-', $date[1]));
        }

        // if ($request->query('start_date')) {
        //     $projects->where('start', '>=', $request->query('start_date'));
        // }

        // if ($request->query('end_date')) {
        //     $projects->where('end', '<=', $request->query('end_date'));
        // }

        $counties = County::get(['name', 'id']);

        return Inertia::render('Public/Projects/Projects', [
            'query' => $projects->paginate()->withQueryString(),
            'counties' => $counties,
            'categories' =>  ActivityDomain::all(),
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
            $name = explode(' ', $request->name);

            if (\is_array($name) && ! empty($name)) {
                $lastName = $name[0] ? $name[0] : '';
                $firstName = (1 < \count($name)) ? implode(' ', \array_slice($name, 1)) : '';
            }
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

        /*
         * TODO: Corner case user volunteers is redirect to VolunteerThankYou page
         *  with project but if refreshes the page some data in thank you page is lost
         *  Posibly implementation duplicate ThankYou page and and send parameter of project
         */
        return redirect()->route('volunteer.thanks')->with(['data' => $project]);
    }
}
