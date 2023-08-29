<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Project;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->take(3)->get();

        $bcr_projects = Project::publish()->paginate(9)->withQueryString();
        $donate_projects = Project::publish()->paginate(9)->withQueryString();

        return Inertia::render('Public/Home', [
            'bcr_projects' => $bcr_projects,
            'donate_projects' => $donate_projects,
            'articles' => $articles,
        ]);
    }
}
