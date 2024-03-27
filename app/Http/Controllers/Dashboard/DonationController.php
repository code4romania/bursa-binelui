<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Enums\EuPlatescStatus;
use App\Http\Controllers\Controller;
use App\Http\Filters\DonationDatesFilter;
use App\Http\Filters\SearchFilter;
use App\Http\Resources\Collections\DonationCollection;
use App\Models\Donation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DonationController extends Controller
{
    public function index(Request $request): Response
    {
        $donations = auth()->user()->organization
            ->donations()
            ->with([
                'project:id,name,organization_id',
                'organization:id,name',
            ])
            ->get();

        $organizations = collect();
        $projects = collect();

        $donations->map(function ($donation) use (&$organizations, &$projects) {
            $organizations->push($donation->project->organization);
            $projects->push($donation->project);
        });

        $dates = $donations
            ->pluck('created_at')
            ->map(fn ($date) => $date->format('Y-m'))
            ->unique();

        return Inertia::render('AdminOng/Donations/Index', [
            'filter' => $request->query('filter'),
            'collection' => new DonationCollection(
                QueryBuilder::for(Donation::class)
                    ->allowedFilters([
                        AllowedFilter::custom('dates', new DonationDatesFilter),
                        AllowedFilter::exact('organization', 'project.organization_id'),
                        AllowedFilter::exact('project', 'project_id'),
                        AllowedFilter::exact('status', 'status'),
                        AllowedFilter::custom('search', new SearchFilter),
                    ])
                    ->where('organization_id', auth()->user()->organization_id)
                    ->with('project:id,name,organization_id')
                    ->allowedSorts('created_at', 'amount')
                    ->defaultSorts('-created_at')
                    ->paginate()
                    ->withQueryString()
            ),
            'organizations' => $organizations->pluck('name', 'id'),
            'projects' => $projects->pluck('name', 'id'),
            'statuses' => EuPlatescStatus::options(),
            'dates' => $dates,
        ]);
    }
}
