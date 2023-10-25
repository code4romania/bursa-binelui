<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\EuPlatescStatus;
use App\Http\Filters\DonationDatesFilter;
use App\Http\Filters\ProjectDatesFilter;
use App\Http\Resources\Collections\DonationCollection;
use App\Models\Donation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class DonorController extends Controller
{
    public function index()
    {
        $profile = [
            'description' => '<p>Mulțumim că ești alături de noi. Prin participarea ta activă la această inițiativă, ne arăți că ești preocupat de problemele sociale și că vrei să faci o diferență pozitivă în lumea în care trăim, iar contribuția ta este extrem de valoroasă.</p>
                <p>Prin distribuirea informațiilor despre proiectele de pe Bursa Binelui și încurajând prietenii și familia să se alăture, devii un promotor important al inițiativei noastre.</p>
                <p>Fiecare pas pe care îl facem împreună contează și, împreună, putem face o diferență semnificativă.</p>',
            'donations_place' => '5%',
            'donations_status' => [
                'Ai donat către mai mult de 5 organizații',
                'Volunariezi la 3 organizații',
                'Ești abonat la newsletterul de bine',
                'Ai distribuit de multiple ori informații utile',
            ],
        ];

        return Inertia::render('Donor/Dashboard', [
            'profile' => $profile,
            'badges' => auth()->user()->badges
                ->map(fn ($badge) => $badge->only('image', 'title', 'description')),
        ]);
    }

    public function donations(Request $request)
    {
        $donations = auth()->user()->donations()->with(['project:id,name,organization_id', 'organization:id,name'])->get();

        $organizations = collect([]);
        $projects = collect([]);

        $donations->map(function ($donation) use (&$organizations, &$projects) {
            $organizations->push($donation->project->organization);
            $projects->push($donation->project);
        });
        $dates = $donations->pluck('created_at')->map(fn ($date) => $date->format('Y-m'))->unique();


        return Inertia::render('Donor/Donations', [
            'filter' => $request->query('filter'),
            'collection' => new DonationCollection(
                QueryBuilder::for(Donation::class)
                    ->where('user_id', auth()->user()->id)
                    ->with('project:id,name,organization_id')
                    ->allowedFilters([

                        AllowedFilter::custom('date', new DonationDatesFilter),
                        AllowedFilter::exact('organization', 'project.organization_id'),
                        AllowedFilter::exact('project', 'project_id'),
                        AllowedFilter::exact('status', 'status'),


                    ])
                    ->allowedSorts([
                        AllowedSort::field('publish_date', 'start'),
                        AllowedSort::field('end_date', 'end'),
                    ])
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
