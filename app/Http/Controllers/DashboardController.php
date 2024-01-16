<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response|RedirectResponse
    {
        if (auth()->user()->belongsToOrganization()) {
            return  $this->ongDashboard();
        }
        if (auth()->user()->isDonor()) {
            return $this->donorDashboard();
        }
        abort(403, 'You are not authorized to access this page.');
    }

    private function donorDashboard()
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

    private function ongDashboard()
    {
        $organization = auth()->user()->organization;
        $data = Cache::remember('organization_id_stats', 60, function () use ($organization) {
            return [
                'organization' => [
                    'status' => $organization->status,
                    'name' => $organization->name,
                    'has_statute' => $organization->has_statute,
                ],
                'projects' => [
                    'total' => $organization->projects->count(),
                    'approved' => $organization->projects()->whereIsApproved()->count(),
                    'pending' => $organization->projects()->whereIsPending()->count(),
                    'rejected' => $organization->projects()->whereIsRejected()->count(),
                    'draft' => $organization->projects()->whereIsDraft()->count(),
                    'published' => $organization->projects()->whereIsPublished()->count(),
                    'open' => $organization->projects()->whereIsOpen()->count(),
                    'closed' => $organization->projects()->whereIsClosed()->count(),
                    'starts_soon' => $organization->projects()->whereStartsSoon()->count(),
                ],
                'tickets' => [
                    'total' => $organization->tickets->count(),
                    'open' => $organization->tickets()->whereOpen()->count(),
                    'closed' => $organization->tickets()->whereClosed()->count(),
                ],
            ];
        });


        return Inertia::render('AdminOng/Dashboard', [
            'data' => $data,
        ]);
    }
}
