<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::publish()->paginate()->withQueryString();

        return Inertia::render('Public/Projects/Projects', [
            'query' => $projects,
        ]);
    }
}
