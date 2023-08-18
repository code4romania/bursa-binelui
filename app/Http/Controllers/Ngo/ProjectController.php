<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ngo;

use App\Enums\ProjectStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreRequest;
use App\Models\ActivityDomain;
use App\Models\County;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\User;
use App\Notifications\Admin\ProjectCreated as ProjectCreatedAdmin;
use App\Notifications\Ngo\ProjectCreated;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projectStatus = $request->get('project_status');
        $projects = Project::query()->with('organization')->where('organization_id', auth()->user()->organization_id);
        if ($projectStatus)
        {
            $projects = $projects->where('status', $projectStatus);
        }

        return Inertia::render('AdminOng/Projects/Projects', [
            'query' => $projects->paginate(16)->withQueryString(),
            'projectStatus' => $projectStatus,
        ]);
    }

    public function create()
    {
        $counties = cache()->remember('counties', 60 * 60 * 24, function () {
            return \App\Models\County::get(['name', 'id']);
        });

        $projectCategories = cache()->remember('projectCategories', 60 * 60 * 24, function () {
            return ProjectCategory::get(['name', 'id']);
        });

        return Inertia::render('AdminOng/Projects/AddProject', [
            'counties' => $counties,
            'projectCategories' => $projectCategories,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $project = (new ProjectService(Project::class))->create($data);
        $project->addAllMediaFromRequest()->each(function ($fileAdder) {
            $fileAdder->toMediaCollection('project_files');
        });
        return redirect()->route('admin.ong.project.edit', $project->id)->with('success', 'Project created.');
    }

    public function edit(Project $project)
    {
        $this->authorize('view', $project);
        $project->load('media');
        $counties = County::get(['name', 'id']);

        return Inertia::render('AdminOng/Projects/EditProject', [
            'project' => $project,
            'counties' => $counties,
            'projectCategories' => ProjectCategory::get(['name', 'id']),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('editAsNgo', $project);

        if ($request->has('counties')) {
            $project->counties()->sync(collect($request->get('counties'))->pluck('id'));
        }
        if ($request->has('categories')) {
            $project->categories()->sync(collect($request->get('categories'))->pluck('id'));
        }
        $project->update($request->all());
        return redirect()->back()->with('success_message', 'Project updated.');
    }

    public function changeStatus($id, Request $request)
    {
        try {
            (new ProjectService(Project::class))->changeStatus($id, $request->get('status'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error_message', $exception->getMessage());
        }
        return redirect()->back()->with('success_message', 'Project status changed.');
    }
}
