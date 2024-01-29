<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\EuPlatescStatus;
use App\Http\Filters\AcceptsVolunteersFilter;
use App\Http\Filters\CountiesFilter;
use App\Http\Filters\ProjectCategoriesFilter;
use App\Http\Filters\ProjectDatesFilter;
use App\Http\Filters\ProjectStatusFilter;
use App\Http\Filters\SearchFilter;
use App\Http\Resources\Collections\ProjectCardCollection;
use App\Http\Resources\Project\ShowProjectResource;
use App\Http\Sorts\ProjectDonationsCountSort;
use App\Http\Sorts\ProjectDonationsSumSort;
use App\Models\Project;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{
    public function index(Request $request): Response
    {
        return $this->projectList($request, 'list');
    }

    public function map(Request $request): Response
    {
        return $this->projectList($request, 'map');
    }

    protected function projectList(Request $request, string $view): Response
    {
        return Inertia::render('Public/Projects/Index', [
            'view' => $view,
            'categories' => $this->getProjectCategories(),
            'counties' => $this->getCounties(),
            'google_maps_api_key' => config('services.google_maps_api_key'),
            'collection' => new ProjectCardCollection(
                QueryBuilder::for(Project::class)
                    ->allowedFilters([
                        AllowedFilter::custom('county', new CountiesFilter),
                        AllowedFilter::custom('category', new ProjectCategoriesFilter),
                        AllowedFilter::custom('date', new ProjectDatesFilter),
                        AllowedFilter::custom('status', new ProjectStatusFilter),
                        AllowedFilter::custom('volunteers', new AcceptsVolunteersFilter),
                        AllowedFilter::custom('search', new SearchFilter),
                    ])
                    ->allowedSorts([
                        AllowedSort::field('publish_date', 'start'),
                        AllowedSort::field('end_date', 'end'),
                        AllowedSort::field('target', 'target_budget'),
                        AllowedSort::custom('donations_total', new ProjectDonationsSumSort),
                        AllowedSort::custom('donations_count', new ProjectDonationsCountSort),
                    ])
                    ->whereIsPublished()
                    ->orderBy('status_updated_at', 'desc')
                    ->paginate()
                    ->withQueryString()
            ),
        ]);
    }

    public function show(Project $project)
    {
        if (! $project->isPublished() ) {
           $this->authorize('view', $project);
        }

        return Inertia::render('Public/Projects/Show', [
            'project' => new ShowProjectResource($project),
        ]);
    }

    public function donate(Project $project, Request $request)
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
            'status' => EuPlatescStatus::INITIALIZE,
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
