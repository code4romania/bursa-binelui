<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\County;
use App\Models\Project;
use Inertia\Inertia;

class RegionalController extends Controller
{
    public function index()
    {

        $editions = [
            [
                'href' => '1',
                'name' => 'Campionatul de bine 2020',
            ],
            [
                'href' => '2',
                'name' => 'Campionatul de bine 2019',
            ],
            [
                'href' => '3',
                'name' => 'Campionatul de bine 2018',
            ],
        ];

        $articles = [
            [
                'id' => 1,
                'img' => '/images/project_img.png',
                'author' => 'Ion Popescu',
                'name' => 'Importanța educației remediare în România în timpul pandemiei',
                'team' => 'Echipa BCR',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto accusantium praesentium eius, ut atque fuga culpa, similique sequi cum eos quis dolorum.',
                'date' => '15.02.2022',
            ],
            [
                'id' => 2,
                'img' => '/images/project_img.png',
                'author' => 'Ion Popescu',
                'name' => 'Importanța educației remediare în România în timpul pandemiei',
                'team' => 'Echipa BCR',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto accusantium praesentium eius, ut atque fuga culpa, similique sequi cum eos quis dolorum.',
                'date' => '15.02.2022',
            ],
            [
                'id' => 3,
                'img' => '/images/project_img.png',
                'author' => 'Ion Popescu',
                'name' => 'Importanța educației remediare în România în timpul pandemiei',
                'team' => 'Echipa BCR',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto accusantium praesentium eius, ut atque fuga culpa, similique sequi cum eos quis dolorum.',
                'date' => '15.02.2022',
            ],
        ];

        $registration = [
            'start' => '2023-06-01',
            'end' => '2023-07-20'
        ];

        $parteners = [
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png'
        ];

        $faqs = [
            [
                'title' => 'Title 1',
                'content' => 'Content 1'
            ],
            [
                'title' => 'Title 2',
                'content' => 'Content 2'
            ],
            [
                'title' => 'Title 3',
                'content' => 'Content 3'
            ],
            [
                'title' => 'Title 4',
                'content' => 'Content 4'
            ]
        ];

        $projects = Project::publish()->paginate(9)->withQueryString();

        return Inertia::render('Public/Regional/Regional', [
            'query' => $projects,
            'editions' => $editions,
            'articles' => $articles,
            'parteners' => $parteners,
            'registration' => $registration,
            'faqs' => $faqs
        ]);
    }

    public function edition()
    {
        $editions = [
            [
                'href' => '1',
                'name' => 'Campionatul de bine 2020',
            ],
            [
                'href' => '2',
                'name' => 'Campionatul de bine 2019',
            ],
            [
                'href' => '3',
                'name' => 'Campionatul de bine 2018',
            ],
        ];

        $articles = [
            [
                'id' => 1,
                'img' => '/images/project_img.png',
                'author' => 'Ion Popescu',
                'name' => 'Importanța educației remediare în România în timpul pandemiei',
                'team' => 'Echipa BCR',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto accusantium praesentium eius, ut atque fuga culpa, similique sequi cum eos quis dolorum.',
                'date' => '15.02.2022',
            ],
            [
                'id' => 2,
                'img' => '/images/project_img.png',
                'author' => 'Ion Popescu',
                'name' => 'Importanța educației remediare în România în timpul pandemiei',
                'team' => 'Echipa BCR',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto accusantium praesentium eius, ut atque fuga culpa, similique sequi cum eos quis dolorum.',
                'date' => '15.02.2022',
            ],
            [
                'id' => 3,
                'img' => '/images/project_img.png',
                'author' => 'Ion Popescu',
                'name' => 'Importanța educației remediare în România în timpul pandemiei',
                'team' => 'Echipa BCR',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto accusantium praesentium eius, ut atque fuga culpa, similique sequi cum eos quis dolorum.',
                'date' => '15.02.2022',
            ],
        ];

        $registration = [
            'start' => '2023-06-01',
            'end' => '2023-07-20'
        ];

        $parteners = [
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png'
        ];

        $faqs = [
            [
                'title' => 'Title 1',
                'content' => 'Content 1'
            ],
            [
                'title' => 'Title 2',
                'content' => 'Content 2'
            ],
            [
                'title' => 'Title 3',
                'content' => 'Content 3'
            ],
            [
                'title' => 'Title 4',
                'content' => 'Content 4'
            ]
        ];

        $projects = Project::publish()->paginate(9)->withQueryString();
        return Inertia::render('Public/Regional/LastEdition', [
            'query' => $projects,
            'editions' => $editions,
            'articles' => $articles,
            'parteners' => $parteners,
            'registration' => $registration,
            'faqs' => $faqs
        ]);
    }

    public function project(Project $project)
    {
        \Log::info(print_r($project, true));

        return Inertia::render('Public/Regional/Project', [
            'project' => $project,
        ]);
    }
}
