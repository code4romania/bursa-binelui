<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Filters\CountiesFilter;
use App\Http\Filters\ProjectCategoriesFilter;
use App\Models\Donation;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Tpetry\QueryExpressions\Function\Aggregate\Count;
use Tpetry\QueryExpressions\Function\Aggregate\Sum;
use Tpetry\QueryExpressions\Language\Alias;

class EvolutionController extends Controller
{
    public function __invoke(Request $request): Response
    {
        if (! auth()->check() || ! auth()->user()->isSuperUser()) {
            return abort(404);
        }
        $donations = Donation::query()
            ->select(
                [
                    new Alias(new Count('id'), 'number'),
                    new Alias(new Sum('amount'), 'amount'),

                ]
            )
            ->selectRaw('DATE(created_at) as date')
            ->where('created_at', '>', now()->startOfYear())
            ->groupByRaw('date')
            ->orderBy('date')
            ->get();

        $totalAmountDonation = $donations->sum('amount');
        $totalNumberDonation = $donations->sum('number');

        $categoriesWithDonations = ProjectCategory::query()
            ->withCount('donations')
            ->withSum('donations', 'amount')
            ->withCount(['projects' => function ($query) {
                $query->whereIsApproved();
            }])
            ->withSum('projects', 'target_budget')
            ->get();

        $projects = QueryBuilder::for(Project::class)
            ->allowedFilters([
                AllowedFilter::custom('county', new CountiesFilter),
                AllowedFilter::custom('category', new ProjectCategoriesFilter),
            ])
            ->whereIsApproved()
            ->select(
                [
                    new Alias(new Count('*'), 'number'),
                ]
            )
            ->withoutEagerLoads()
            ->selectRaw('DATE(created_at) as date')
            ->where('created_at', '>', now()->startOfYear())
            ->groupByRaw('date')
            ->orderBy('date')
            ->get();

        $categories = ProjectCategory::query()
            ->addSelect('id as value')
            ->addSelect('name as label')
            ->whereHas('projects', fn ($query) => $query->whereIsApproved())
            ->get();

        return Inertia::render('Public/Evolution/Evolution', [
            'donations' => $donations,
            'totalAmountDonations' => $totalAmountDonation,
            'totalNumberDonations' => $totalNumberDonation,
            'totalProjects' => $projects->sum('number'),
            'categoriesWithDonations' => $categoriesWithDonations,
            'counties' => $this->getCounties(),
            'projects' => $projects,
            'projectCategories' => $categories,
            'filter' => $request->query('filter'),

        ]);
    }
}
