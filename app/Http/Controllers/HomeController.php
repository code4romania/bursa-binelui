<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\BCRProjectCardsResource;
use App\Http\Resources\ProjectCardsResource;
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
                ->publish()
                ->count(),

            'organizations_count' => Organization::query()
                ->isApproved()
                ->count(),

            'projects' => ProjectCardsResource::collection(
                Project::publish()
                    ->inRandomOrder()
                    ->limit(12)
                    ->get()
            ),

            'bcr_projects' => BCRProjectCardsResource::collection(
                Project::publish()
                    // TODO: ->whereOrganizationIsBCR()
                    ->limit(12)
                    ->get()
            ),

            'articles' => $articles,
        ]);
    }
}
