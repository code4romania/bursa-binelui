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
        return Inertia::render('Public/Home', [
            'projects_count' => Project::query()
                ->whereIsOpen()
                ->count(),

            'organizations_count' => Organization::query()
                ->isApproved()
                ->count(),

            'projects' => ProjectCardResource::collection(
                Project::whereIsOpen()
                    ->latest()
                    ->limit(12)
                    ->get()
            ),

            'bcr_projects' => BCRProjectCardResource::collection(
                BCRProject::query()
                    ->latest()
                    ->with('county')
                    ->limit(12)
                    ->get()
            ),

            'articles' => ArticleCardResource::collection(
                Article::query()
                    ->latest()
                    ->wherePublished()
                    ->limit(3)
                    ->get()
            ),
        ]);
    }
}
