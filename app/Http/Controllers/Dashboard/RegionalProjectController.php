<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegionalProject\StoreRequest;
use App\Http\Resources\Edition\EditionShowResource;
use App\Http\Resources\GalaProjectCardResource;
use App\Models\County;
use App\Models\Edition;
use App\Models\Gala;
use App\Models\GalaProject;
use App\Models\ProjectCategory;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegionalProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organization = auth()->user()->organization()->first();
        $edition = Edition::currentEditon()->with('gales')->first();
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

        return Inertia::render('AdminOng/GalaProjects/AddProject', [
            'counties' => $gala->counties,
            'projectCategories' => $gala->edition->editionCategories,
            'startDate' => $gala->start_sign_up,
            'endDate' => $gala->end_sign_up,

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

        return redirect()->route('dashboard.projects.edit', $project->id)->with('success', 'Project created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalaProject $project)
    {
//        $this->authorize('view', $project);
        $project->load('media');

        return Inertia::render('AdminOng/Projects/EditRegionalProject', [
            'project' => $project,
            'counties' => County::get(['name', 'id']),
            'projectCategories' => ProjectCategory::get(['name', 'id']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegionalProject $project)
    {
//        $this->authorize('editAsNgo', $project);;
        if ($request->has('counties')) {
            $project->counties()->sync(collect($request->get('counties'))->pluck('id'));
        }
        $project->update($request->all());

        return redirect()->back()
            ->with('success', 'Project updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changeStatus(Request $request, string $id)
    {
        try {
            (new ProjectService(RegionalProject::class))->changeStatus($id, $request->get('status'));
        } catch (\Exception $exception) {
            return redirect()->back()
                ->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('success', 'Project status changed.');
    }
}
