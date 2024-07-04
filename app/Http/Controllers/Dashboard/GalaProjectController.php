<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Enums\OrganizationType;
use App\Enums\ProjectArea;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegionalProject\StoreRequest;
use App\Http\Resources\Edition\EditionShowResource;
use App\Http\Resources\GalaProjectCardResource;
use App\Models\Edition;
use App\Models\Gala;
use App\Models\GalaProject;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GalaProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organization = auth()->user()->organization()->first();
        $edition = Edition::currentEdition()->with('gales')->first();
        $projects = GalaProject::whereBelongsToOrganization($organization)->paginate();

        return Inertia::render('AdminOng/GalaProjects/Projects', [
            'query' => GalaProjectCardResource::collection($projects),
            'edition' => EditionShowResource::make($edition),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Gala $gala)
    {
        if (! $gala->registrationIsOpen) {
            return redirect()->back();
        }
        $gala->edition->load('editionCategories');

        return Inertia::render('AdminOng/GalaProjects/Add', [
            'counties' => $gala->counties()->get(['name', 'counties.id']),
            'projectCategories' => $gala->edition->editionCategories()->get(['name', 'edition_categories.id']),
            'galaTitle' => $gala->title,
            'startDate' => $gala->start_sign_up,
            'endDate' => $gala->end_sign_up,
            'areas' => ProjectArea::optionsForRadio(),
            'galaId' => $gala->id,
            'organizationTypes' => OrganizationType::optionsForRadio(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $project = (new ProjectService(GalaProject::class))->create($data);
        $project->addAllMediaFromRequest()->each(function ($fileAdder) {
            $fileAdder->toMediaCollection('regionalProjectFiles');
        });

        return redirect()
            ->route('dashboard.projects.gala.edit', $project->slug)
            ->with('success', __('regional_projects.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(GalaProject $project)
    {
        $this->authorize('view', $project);
        $project->load('media');

        return Inertia::render('AdminOng/GalaProjects/View', [
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalaProject $project)
    {
        $this->authorize('update', $project);
        $project->load('media');

        return Inertia::render('AdminOng/GalaProjects/Edit', [
            'project' => $project,
            'counties' => $project->gala->counties()->get(['name', 'counties.id']),
            'projectCategories' => $project->edition->editionCategories()->get(['name', 'edition_categories.id']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GalaProject $project)
    {
        $this->authorize('update', $project);
        if ($request->has('counties')) {
            $project->counties()->sync(collect($request->get('counties'))->pluck('id'));
        }
        if ($request->has('categories')) {
            $project->categories()->sync(collect($request->get('categories'))->pluck('id'));
        }
        $project->update($request->all());

        return redirect()->back()
            ->with('success', __('project.project_updated'));
    }

    public function changeStatus(Request $request, GalaProject $project)
    {
        try {
            (new ProjectService(GalaProject::class))->changeStatus($project, $request->get('status'));
        } catch (\Exception $exception) {
            return redirect()->back()
                ->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('success', __('project.project_status_changed'));
    }
}
