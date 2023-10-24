<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Articles\ArticleCardResource;
use App\Http\Resources\BCRProjectCardResource;
use App\Http\Resources\ProjectCardResource;
use App\Models\Article;
use App\Models\BCRProject;
use App\Models\Organization;
use App\Models\Project;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->take(3)->get();

        return Inertia::render('Public/Home', [
            'projects_count' => Project::query()
                ->whereIsOpen()
                ->count(),

            'organizations_count' => Organization::query()
                ->isApproved()
                ->count(),

            'projects' => ProjectCardResource::collection(
                Project::whereIsOpen()
                    ->inRandomOrder()
                    ->limit(12)
                    ->get()
            ),

            'bcr_projects' => BCRProjectCardResource::collection(
                BCRProject::query()
                    ->with('county')
                    ->limit(12)
                    ->get()
            ),

            'articles' => ArticleCardResource::collection(
                Article::query()
                    ->wherePublished()
                    ->inRandomOrder()
                    ->limit(3)
                    ->get()
            ),
        ]);
    }
}
