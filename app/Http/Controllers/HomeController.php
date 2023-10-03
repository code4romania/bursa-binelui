<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Articles\ArticleCardResource;
use App\Models\Article;
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

            'projects' => ProjectCardsResource::collection(
                Project::whereIsOpen()
                    ->inRandomOrder()
                    ->limit(12)
                    ->get()
            ),

            'bcr_projects' => BCRProjectCardsResource::collection(
                Project::whereIsOpen()
                    // TODO: ->whereOrganizationIsBCR()
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
