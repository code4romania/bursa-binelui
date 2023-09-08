<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\EuPlatescStatus;
use App\Http\Filters\AcceptsVolunteersFilter;
use App\Http\Filters\CategoryFilter;
use App\Http\Filters\CountiesFilter;
use App\Http\Filters\ProjectDatesFilter;
use App\Http\Filters\ProjectStatusFilter;
use App\Http\Filters\SearchFilter;
use App\Http\Resources\ProjectCardsResource;
use App\Models\Project;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Public/Projects/Index', [
            'view' => 'list',
            'filter' => $request->query('filter'),
            'categories' => $this->getProjectCategories(),
            'counties' => $this->getCounties(),
            'resource' => ProjectCardsResource::collection(
                QueryBuilder::for(Project::class)
                    ->allowedFilters([
                        AllowedFilter::custom('county', new CountiesFilter),
                        AllowedFilter::custom('category', new CategoryFilter),
                        AllowedFilter::custom('date', new ProjectDatesFilter),
                        AllowedFilter::custom('status', new ProjectStatusFilter),
                        AllowedFilter::custom('volunteers', new AcceptsVolunteersFilter),
                        AllowedFilter::custom('search', new SearchFilter),
                    ])
                    ->wherePublished()
                    ->paginate()
                    ->withQueryString()
            ),
        ]);
    }

    public function map(Request $request): Response
    {
        return Inertia::render('Public/Projects/Index', [
            'view' => 'map',
            'filter' => $request->query('filter'),
            'categories' => $this->getProjectCategories(),
            'counties' => $this->getCounties(),
            'google_maps_api_key' => config('services.google_maps_api_key'),
            'resource' => ProjectCardsResource::collection(
                QueryBuilder::for(Project::class)
                    ->allowedFilters([
                        AllowedFilter::custom('county', new CountiesFilter),
                        AllowedFilter::custom('category', new CategoryFilter),
                        AllowedFilter::custom('date', new ProjectDatesFilter),
                        AllowedFilter::custom('status', new ProjectStatusFilter),
                        AllowedFilter::custom('volunteers', new AcceptsVolunteersFilter),
                        AllowedFilter::custom('search', new SearchFilter),
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
        $attributes = $request->validate([
            'terms' => ['required', 'accepted'],
            'email' => ['required', 'email'],
            'name' => 'required',
            'phone' => 'required',
        ]);

        $volunteer = Volunteer::create([
            'user_id' => auth()->user()->id ?? null,
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'phone' => $attributes['phone'],
        ]);

        $volunteer->projects()->attach($project->id, ['status' => 'pending']);

        /*
         * TODO: Corner case user volunteers is redirect to VolunteerThankYou page
         *  with project but if refreshes the page some data in thank you page is lost
         *  Posibly implementation duplicate ThankYou page and and send parameter of project
         */
        return redirect()->route('volunteer.thanks')->with(['data' => $project]);
    }
}
