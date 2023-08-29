<?php

namespace App\Http\Controllers;

use App\Http\Resources\PageResource;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response|RedirectResponse
    {
        if (auth()->user()->isNgoAdmin()) {
            return redirect()->route('admin.ong.edit');
        }
        if (auth()->user()->isDonor()) {
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
        abort(403, 'You are not authorized to access this page.');
    }
}
