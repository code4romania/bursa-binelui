<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;

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

    public function donations()
    {
        $donations = [
            'current_page' => 2,
            'data' => [
                [
                    'id' => 1,
                    'organization' => 'Asociația Un Zâmbet pentru copilul tău',
                    'project' => 'Zambet pentru copiii noștri',
                    'created_at' => '12.08.2022',
                    'amount' => '300',
                ],
                [
                    'id' => 2,
                    'organization' => 'Asociația Un Zâmbet pentru copilul tău',
                    'project' => 'Zambet pentru copiii noștri',
                    'created_at' => '12.08.2022',
                    'amount' => '300',
                ],

                [
                    'id' => 3,
                    'organization' => 'Asociația Un Zâmbet pentru copilul tău',
                    'project' => 'Zambet pentru copiii noștri',
                    'created_at' => '12.08.2022',
                    'amount' => '300',
                ],
                [
                    'id' => 4,
                    'organization' => 'Asociația Un Zâmbet pentru copilul tău',
                    'project' => 'Zambet pentru copiii noștri',
                    'created_at' => '12.08.2022',
                    'amount' => '300',
                ],
            ],
            'first_page_url' => 'http=>//bursabinelui.test/proiecte?page=1',
            'from'=> 1,
            'last_page'=> 2,
            'last_page_url'=> 'http://bursabinelui.test/proiecte?page=2',
            'links'=> [
                [
                    'url'=> 'http://bursabinelui.test/proiecte?page=1',
                    'label'=> '1',
                    'active'=> true,
                ],
                [
                    'url'=> 'http://bursabinelui.test/proiecte?page=1',
                    'label'=> '1',
                    'active'=> true,
                ],
                [
                    'url'=> 'http://bursabinelui.test/proiecte?page=2',
                    'label'=> '2',
                    'active'=> false,
                ],
                [
                    'url'=> 'http://bursabinelui.test/proiecte?page=3',
                    'label'=> '3',
                    'active'=> false,
                ],
                [
                    'url'=> 'http://bursabinelui.test/proiecte?page=1',
                    'label'=> '1',
                    'active'=> true,
                ],
            ],
            'next_page_url'=> 'http://bursabinelui.test/proiecte?page=3',
            'path'=> 'http://bursabinelui.test/proiecte',
            'per_page'=> 15,
            'prev_page_url'=> 'http://bursabinelui.test/proiecte?page=1',
            'to'=> 15,
            'total'=> 20,
        ];

        return Inertia::render('Donor/Donations', [
            'donations' => $donations,
        ]);
    }
}
