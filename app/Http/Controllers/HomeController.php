<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {

        $projects = Project::publish()->paginate(9)->withQueryString();
        return Inertia::render('Public/Home', [
            'query' => $projects
        ]);
    }
}
