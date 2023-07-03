<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DonorController extends Controller
{
    public function index()
    {
        $profile = [
            'description' =>
                '<p>Mulțumim că ești alături de noi. Prin participarea ta activă la această inițiativă, ne arăți că ești preocupat de problemele sociale și că vrei să faci o diferență pozitivă în lumea în care trăim, iar contribuția ta este extrem de valoroasă.</p>
                <p>Prin distribuirea informațiilor despre proiectele de pe Bursa Binelui și încurajând prietenii și familia să se alăture, devii un promotor important al inițiativei noastre.</p>
                <p>Fiecare pas pe care îl facem împreună contează și, împreună, putem face o diferență semnificativă.</p>',
            'donations_place' => '5%',
            'donations_status' => [
                'Ai donat către mai mult de 5 organizații',
                'Volunariezi la 3 organizații',
                'Ești abonat la newsletterul de bine',
                'Ai distribuit de multiple ori informații utile'
            ],
        ];

        $badges = [
            [
                'name' => 'multiple_donor',
                'title' => 'multiple_donor_title',
                'description' => 'multiple_donor_description'
            ],
            [
                'name' => 'subscriber',
                'title' => 'subscriber_donor_title',
                'description' => 'subscriber_donor_description'
            ],
            [
                'name' => 'long_race',
                'title' => 'long_race_title',
                'description' => 'long_race_description'
            ],
            [
                'name' => 'supporter',
                'title' => 'supporter_donor_title',
                'description' => 'supporter_donor_description'
            ],
            [
                'name' => 'month_volunteer',
                'title' => 'month_volunteer_title',
                'description' => 'month_volunteer_description'
            ],
            [
                'name' => 'top_donor',
                'title' => 'top_donor_title',
                'description' => 'top_donor_description'
            ],
            [
                'name' => 'donor',
                'title' => 'recurent_donor_title',
                'description' => 'recurent_donor_description'
            ]
        ];

        return Inertia::render('Donor/Dashboard', [
            'profile' => $profile,
            'badges' => $badges
        ]);
    }

    public function donations()
    {
        $donations = [
            "current_page" => 2,
            "data" => [
                [
                    'id' => 1,
                    'organization' => 'Asociația Un Zâmbet pentru copilul tău',
                    'project' => 'Zambet pentru copiii noștri',
                    'created_at' => '12.08.2022',
                    'amount' => '300'
                ],
                [
                    'id' => 2,
                    'organization' => 'Asociația Un Zâmbet pentru copilul tău',
                    'project' => 'Zambet pentru copiii noștri',
                    'created_at' => '12.08.2022',
                    'amount' => '300'
                ],

                [
                    'id' => 3,
                    'organization' => 'Asociația Un Zâmbet pentru copilul tău',
                    'project' => 'Zambet pentru copiii noștri',
                    'created_at' => '12.08.2022',
                    'amount' => '300'
                ],
                [
                    'id' => 4,
                    'organization' => 'Asociația Un Zâmbet pentru copilul tău',
                    'project' => 'Zambet pentru copiii noștri',
                    'created_at' => '12.08.2022',
                    'amount' => '300'
                ]
            ],
            "first_page_url" => "http=>//bursabinelui.test/proiecte?page=1",
            "from"=> 1,
            "last_page"=> 2,
            "last_page_url"=> "http://bursabinelui.test/proiecte?page=2",
            "links"=> [
                [
                    "url"=> "http://bursabinelui.test/proiecte?page=1",
                    "label"=> "1",
                    "active"=> true
                ],
                [
                    "url"=> "http://bursabinelui.test/proiecte?page=1",
                    "label"=> "1",
                    "active"=> true
                ],
                [
                    "url"=> "http://bursabinelui.test/proiecte?page=2",
                    "label"=> "2",
                    "active"=> false
                ],
                [
                    "url"=> "http://bursabinelui.test/proiecte?page=3",
                    "label"=> "3",
                    "active"=> false
                ],
                [
                    "url"=> "http://bursabinelui.test/proiecte?page=1",
                    "label"=> "1",
                    "active"=> true
                ],
            ],
            "next_page_url"=> "http://bursabinelui.test/proiecte?page=3",
            "path"=> "http://bursabinelui.test/proiecte",
            "per_page"=> 15,
            "prev_page_url"=> 'http://bursabinelui.test/proiecte?page=1',
            "to"=> 15,
            "total"=> 20
        ];

        return Inertia::render('Donor/Donations', [
            'donations' => $donations,
        ]);
    }
}
