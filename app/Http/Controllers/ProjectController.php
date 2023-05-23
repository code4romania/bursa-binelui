<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ProjectCategory;
use App\Http\Requests\Project\StoreRequest;
use App\Models\County;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with('organization')->where('organization_id', auth()->user()->organization_id)->paginate();

        return Inertia::render('AdminOng/Projects/Projects', [
            'query' => $projects,
        ]);
    }

    public function create()
    {
        $countries = County::get(['name', 'id']);

        return Inertia::render('AdminOng/Projects/AddProject', [
            'countries' => $countries,
            'projectCategories' => ProjectCategory::values(),
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['organization_id'] = auth()->user()->organization_id;
        $data['slug'] = \Str::slug($data['name']);
        $project = Project::create($data);
        $project->addAllMediaFromRequest();

        return redirect()->route('admin.ong.project.edit', $project->id)->with('success', 'Project created.');
    }

    public function edit(Project $project)
    {
        $project->load('media');
        $countries = County::get(['name', 'id']);

        return Inertia::render('AdminOng/Projects/EditProject', [
            'project' => $project,
            'countries' => $countries,
            'projectCategories' => ProjectCategory::values(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $project->update($request->all());
    }
}
