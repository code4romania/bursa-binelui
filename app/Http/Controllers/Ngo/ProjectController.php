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
        $projectStatus = $request->get('project_status', 'approved');
        $projects = Project::with('organization')->where('status', $projectStatus)->where('organization_id', auth()->user()->organization_id)->paginate(16)->withQueryString();

        return Inertia::render('AdminOng/Projects/Projects', [
            'query' => $projects,
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
        $project = (new ProjectService())->create($data);
        $project->addAllMediaFromRequest()->each(function ($fileAdder) {
            $fileAdder->toMediaCollection('project_files');
        });
        $redirectUrl = $project->status === ProjectStatus::draft ? route('project', ['project'=>$project->slug]) : route('admin.ong.project.edit', $project->id);

        return redirect()->to($redirectUrl)->with('success', 'Project created.');
    }

    public function edit(Project $project)
    {
        $this->authorize('view', $project);
        $project->load('media');
        $counties = County::get(['name', 'id']);

        return Inertia::render('AdminOng/Projects/EditProject', [
            'project' => $project,
            'counties' => $counties,
            'projectCategories' =>  ProjectCategory::get(['name', 'id']),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('editAsNgo', $project);

        if ($request->has('counties')) {
            $project->counties()->sync(collect($request->get('counties'))->pluck('id'));
        }
        $project->update($request->all());
    }
}
