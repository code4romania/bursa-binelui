<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;

class AdminBBTemporary extends Controller
{
    public function about()
    {
        $content = [
            'title' => 'Despre Bursa Binelui',
            'subtitle' => 'Despre subtitle',
            'body' => 'content',
        ];

        return Inertia::render('Public/About', [
            'content' => $content,
        ]);
    }

    public function faqs()
    {
        $faqs = [
            'title' => 'Intrebări frecvente',
            'content' => '
                    <p>Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.</p>',
            'faqs' => [
                [
                    'title' => 'How do you make holy water?',
                    'content' => '<p>Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.</p>',
                ],
                [
                    'title' => 'How do you make holy water?',
                    'content' => '<p>Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.</p>',
                ],
                [
                    'title' => 'How do you make holy water?',
                    'content' => '<p>Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.</p>',
                ],
                [
                    'title' => 'How do you make holy water?',
                    'content' => '<p>Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.</p>',
                ],
                [
                    'title' => 'How do you make holy water?',
                    'content' => '<p>Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.</p>',
                ],
            ],
        ];

        return Inertia::render('Public/Website/Faqs', [
            'faqs' => $faqs,
        ]);
    }
}
