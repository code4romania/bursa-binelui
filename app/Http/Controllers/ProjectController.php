<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\EuPlatescStatus;
use App\Http\Filters\CategoryFilter;
use App\Http\Filters\CountiesFilter;
use App\Http\Filters\ProjectDatesFilter;
use App\Http\Resources\ProjectCardsResource;
use App\Models\County;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Public/Projects/Index', [
            'categories' => ProjectCategory::all(['id', 'name']),
            'counties' => County::all(['id', 'name']),
            'google_maps_api_key' => config('services.google_maps_api_key'),
            'query' => ProjectCardsResource::collection(
                QueryBuilder::for(Project::class)
                    ->allowedFilters([
                        AllowedFilter::custom('c', new CountiesFilter),
                        AllowedFilter::custom('category', new CategoryFilter),
                        AllowedFilter::custom('date', new ProjectDatesFilter),
                    ])
                    ->wherePublished()
                    ->paginate()
                    ->withQueryString()
            ),
        ]);
    }

    public function show(Project $project)
    {
        // TODO: prevent display of unpublished projects

        return Inertia::render('Public/Projects/Show', [
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
            'approval_date' => null,
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
