<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ngo;

use App\Enums\ProjectCategory;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreRequest;
use App\Models\County;
use App\Models\Project;
use App\Models\User;
use App\Notifications\Admin\ProjectCreated as ProjectCreatedAdmin;
use App\Notifications\Ngo\ProjectCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;
use App\Models\ActivityDomain;

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
        $counties = cache()->remember('counties', 60 * 60 * 24, function () {
            return \App\Models\County::get(['name', 'id']);
        });

        $projectCategories = cache()->remember('activityDomains', 60 * 60 * 24, function () {
            return ActivityDomain::get(['name', 'id']);
        });

        return Inertia::render('AdminOng/Projects/AddProject', [
            'counties' => $counties,
            'projectCategories' => $projectCategories,
        ]);
    }

    public function createRegional()
    {
        $counties = cache()->remember('counties', 60 * 60 * 24, function () {
            return \App\Models\County::get(['name', 'id']);
        });

        $projectCategories = cache()->remember('activityDomains', 60 * 60 * 24, function () {
            return ActivityDomain::get(['name', 'id']);
        });


        return Inertia::render('AdminOng/Projects/AddRegionalProject', [
            'counties' => $counties,
            'projectCategories' => $projectCategories,
        ]);
    }

    public function storeRegional(StoreRequest $request)
    {
        $data = $request->validated();
        $data['organization_id'] = auth()->user()->organization_id;
        $data['slug'] = \Str::slug($data['name']);
        $project = Project::create($data);
        if ($request->has('counties')) {
            $project->counties()->attach($data['counties']);
        }
        $project->addAllMediaFromRequest()->each(function ($fileAdder) {
            $fileAdder->toMediaCollection('project_files');
        });

        auth()->user()->notify(new ProjectCreated($project));
        $adminUsers = User::whereRole(UserRole::bb_admin)->get();
        Notification::send($adminUsers, new ProjectCreatedAdmin($project));

        return redirect()->route('admin.ong.project.edit', $project->id)->with('success', 'Project created.');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['organization_id'] = auth()->user()->organization_id;
        $data['slug'] = \Str::slug($data['name']);
        $project = Project::create($data);
        if ($request->has('counties')) {
            $project->counties()->attach($data['counties']);
        }
        $project->addAllMediaFromRequest()->each(function ($fileAdder) {
            $fileAdder->toMediaCollection('project_files');
        });

        auth()->user()->notify(new ProjectCreated($project));
        $adminUsers = User::whereRole(UserRole::bb_admin)->get();
        Notification::send($adminUsers, new ProjectCreatedAdmin($project));

        return redirect()->route('admin.ong.project.edit', $project->id)->with('success', 'Project created.');
    }

    public function edit(Project $project)
    {
        $project->load('media');
        $counties = County::get(['name', 'id']);

        return Inertia::render('AdminOng/Projects/EditProject', [
            'project' => $project,
            'counties' => $counties,
            'projectCategories' => ProjectCategory::values(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        if ($request->has('counties')) {
            $project->counties()->sync(collect($request->get('counties'))->pluck('id'));
        }
        $project->update($request->all());
    }
}
