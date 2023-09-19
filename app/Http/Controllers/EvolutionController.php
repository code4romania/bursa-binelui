<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ActivityDomain;
use App\Models\County;
use Inertia\Inertia;
use Inertia\Response;

class EvolutionController extends Controller
{
    public function __invoke(): Response
    {
        $donations = 102030;
        $amount = 122345;
        $projects = 1000;

        $donations_number = [
            [
                'month' => 'Ian',
                'number' => 23,
            ],
            [
                'month' => 'Feb',
                'number' => 80,
            ],
            [
                'month' => 'Mar',
                'number' => 50,
            ],
            [
                'month' => 'Apr',
                'number' => 100,
            ],
            [
                'month' => 'Mai',
                'number' => 150,
            ],
            [
                'month' => 'Iun',
                'number' => 30,
            ],
        ];

        $donations_amount = [
            [
                'month' => 'Ian',
                'amount' => 1023,
            ],
            [
                'month' => 'Feb',
                'amount' => 180,
            ],
            [
                'month' => 'Mar',
                'amount' => 5200,
            ],
            [
                'month' => 'Apr',
                'amount' => 22100,
            ],
            [
                'month' => 'Mai',
                'amount' => 1250,
            ],
            [
                'month' => 'Iun',
                'amount' => 2230,
            ],
        ];

        $projects_number = [
            [
                'month' => 'Ian',
                'number' => 123,
            ],
            [
                'month' => 'Feb',
                'number' => 280,
            ],
            [
                'month' => 'Mar',
                'number' => 150,
            ],
            [
                'month' => 'Apr',
                'number' => 1100,
            ],
            [
                'month' => 'Mai',
                'number' => 2150,
            ],
            [
                'month' => 'Iun',
                'number' => 330,
            ],
        ];

        $table_data = [
            'current_page' => 1,
            'data' => [
                [
                    'id' => 1,
                    'month' => 'Ian',
                    'number' => 23,
                    'amount' => 400,
                    'domain' => 'Social',
                ],
                [
                    'id' => 2,
                    'month' => 'Ian',
                    'number' => 23,
                    'amount' => 400,
                    'domain' => 'Social',
                ],
                [
                    'id' => 3,
                    'month' => 'Ian',
                    'number' => 23,
                    'amount' => 400,
                    'domain' => 'Social',
                ],
                [
                    'id' => 4,
                    'month' => 'Ian',
                    'number' => 23,
                    'amount' => 400,
                    'domain' => 'Social',
                ],
            ],
            'first_page_url' => 'http://bursabinelui.test/articole?page=1',
            'from' => 1,
            'last_page' => 2,
            'last_page_url' => 'http://bursabinelui.test/articole?page=2',
            'links' => [
                [
                    'url' => 'http://bursabinelui.test/articole?page=1',
                    'label' => '1',
                    'active' => true,
                ],
                [
                    'url' => 'http://bursabinelui.test/articole?page=2',
                    'label' => '2',
                    'active' => false,
                ],
            ],
            'next_page_url' => 'http://bursabinelui.test/articole?page=1',
            'path' => 'http://bursabinelui.test/articole',
            'per_page' => 15,
            'prev_page_url' => null,
            'to' => 15,
            'total' => 20,

        ];

        $counties = County::get(['name', 'id']);

        return Inertia::render('Public/Evolution/Evolution', [
            'donations' => $donations,
            'amount' => $amount,
            'donations_number' => $donations_number,
            'donations_amount' => $donations_amount,
            'projects' => $projects,
            'projects_number' => $projects_number,
            'counties' => $counties,
            'domains' => ActivityDomain::all(),
            'table_data' => $table_data,
        ]);
    }
}
