<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\ProjectCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreRequest;
use App\Models\County;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projectStatus = $request->get('project_status', 'published');
        $projects = Project::with('organization')->where('status', $projectStatus)->where('organization_id', auth()->user()->organization_id)->paginate(16)->withQueryString();

        return Inertia::render('AdminOng/Projects/Projects', [
            'query' => $projects,
            'projectStatus' => $projectStatus,
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
        $project->addAllMediaFromRequest()->each(function ($fileAdder) {
            $fileAdder->toMediaCollection('project_files');
        });

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
