<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Filters\AcceptsVolunteersFilter;
use App\Http\Filters\BcrProjectDatesFilter;
use App\Http\Filters\CountiesFilter;
use App\Http\Filters\ProjectCategoriesFilter;
use App\Http\Filters\ProjectDatesFilter;
use App\Http\Filters\ProjectStatusFilter;
use App\Http\Filters\SearchFilter;
use App\Http\Resources\BCRProjectCardResource;
use App\Http\Resources\BcrProjectResource;
use App\Http\Resources\Collections\BcrProjectCardCollection;
use App\Http\Sorts\ProjectDonationsCountSort;
use App\Http\Sorts\ProjectDonationsSumSort;
use App\Models\BCRProject;
use App\Models\Project;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class BcrProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Public/Bcr/Index', [
            'view' => 'list',
            'categories' => $this->getProjectCategories(),
            'counties' => $this->getCounties(),
            'collection' => new BcrProjectCardCollection(
                QueryBuilder::for(BCRProject::class)
                    ->allowedFilters([
                        AllowedFilter::exact('county', 'county_id'),
                        AllowedFilter::exact('category', 'project_category_id'),
                        AllowedFilter::custom('date', new BcrProjectDatesFilter),
                        AllowedFilter::custom('search', new SearchFilter),
                    ])
                    ->allowedSorts([
                        AllowedSort::field('publish_date', 'start_date'),
                        AllowedSort::field('end_date', 'end_date'),
                    ])
                    ->orderBy('id', 'desc')
                    ->paginate()
                    ->withQueryString()
            ),
        ]);
    }

    public function show(BCRProject $project)
    {
        return Inertia::render('Public/Bcr/Show', [
            'project' => new  BcrProjectResource($project),
        ]);
    }
}
