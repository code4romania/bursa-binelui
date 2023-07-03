<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;

class EvolutionController extends Controller
{
    public function index()
    {
        $donations = 102030;
        $amount = 122345;

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
            ]
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
            ]
        ];


        return Inertia::render('Public/Evolution/Evolution', [
            'donations' => $donations,
            'amount' => $amount,
            'donations_number' => $donations_number,
            'donations_amount' => $donations_amount
        ]);
    }
}
