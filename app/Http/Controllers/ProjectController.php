<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\County;
use App\Models\Project;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::publish()->paginate()->withQueryString();
        $counties = County::whereHas('projects')->get(['name', 'id']);
        return Inertia::render('Public/Projects/Projects', [
            'query' => $projects,
            'counties' => $counties,
        ]);
    }
    public function item(Project $project)
    {
//        dd($project);$project
        return Inertia::render('Public/Projects/Project', [
            'project' => $project,
        ]);
    }
}
