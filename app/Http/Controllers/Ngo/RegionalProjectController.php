<?php

namespace App\Http\Controllers\Ngo;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\ActivityDomain;
use App\Models\Project;
use App\Models\RegionalProject;
use App\Models\User;
use App\Notifications\Admin\ProjectCreated as ProjectCreatedAdmin;
use App\Notifications\Ngo\ProjectCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

class RegionalProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = RegionalProject::where('organization_id', auth()->user()->organization_id)->paginate(16)->withQueryString();

        return Inertia::render('AdminOng/Projects/Projects', [
            'query' => $projects,
//            'projectStatus' => $projectStatus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validated();
        $data['organization_id'] = auth()->user()->organization_id;
        $data['slug'] = \Str::slug($data['name']);
        $project = Project::create($data);
        if ($request->has('counties')) {
            $project->counties()->attach($data['counties']);
        }
        if ($request->has('category')) {
            $project->activityDomains()->attach($data['category']);
        }
        $project->addAllMediaFromRequest()->each(function ($fileAdder) {
            $fileAdder->toMediaCollection('project_files');
        });

        auth()->user()->notify(new ProjectCreated($project));
        $adminUsers = User::whereRole(UserRole::bb_admin)->get();
        Notification::send($adminUsers, new ProjectCreatedAdmin($project));

        return redirect()->route('admin.ong.project.edit', $project->id)->with('success', 'Project created.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
