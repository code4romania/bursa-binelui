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

        $regions = [
            [
                'id' => 1,
                'cover_image' => '/images/project_img.png',
                'status' => 'registration',
                'name' => 'Galele Regionale Muntenia',
            ],
            [
                'id' => 2,
                'cover_image' => '/images/project_img.png',
                'status' => 'finished',
                'name' => 'Galele Regionale Muntenia',
            ],
            [
                'id' => 3,
                'cover_image' => '/images/project_img.png',
                'status' => 'winners',
                'name' => 'Galele Regionale Muntenia',
            ],
            [
                'id' => 4,
                'cover_image' => '/images/project_img.png',
                'status' => 'registration',
                'name' => 'Galele Regionale Muntenia',
            ],
            [
                'id' => 5,
                'cover_image' => '/images/project_img.png',
                'status' => 'finished',
                'name' => 'Galele Regionale Muntenia',
            ],
            [
                'id' => 6,
                'cover_image' => '/images/project_img.png',
                'status' => 'winners',
                'name' => 'Galele Regionale Muntenia',
            ],
        ];

        $registration = [
            'start' => '2023-06-01',
            'end' => '2023-07-20',
        ];

        $parteners = [
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
        ];

        $faqs = [
            [
                'title' => 'Title 1',
                'content' => 'Content 1',
            ],
            [
                'title' => 'Title 2',
                'content' => 'Content 2',
            ],
            [
                'title' => 'Title 3',
                'content' => 'Content 3',
            ],
            [
                'title' => 'Title 4',
                'content' => 'Content 4',
            ],
        ];

        $projects = Project::whereIsOpen()->paginate(9)->withQueryString();

        $countries = County::get(['name', 'id']);

        return Inertia::render('Public/Regional/Regional', [
            'query' => $projects,
            'editions' => $editions,
            'regions' => $regions,
            'parteners' => $parteners,
            'registration' => $registration,
            'faqs' => $faqs,
            'countries' => $countries,
        ]);
    }

    public function edition()
    {
        $editions = [
            [
                'href' => '1',
                'name' => 'Gale Regionale 2020',
            ],
            [
                'href' => '2',
                'name' => 'Gale Regionale 2021',
            ],
            [
                'href' => '3',
                'name' => 'Gale Regionale 2022',
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
            'end' => '2023-07-20',
        ];

        $parteners = [
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
        ];

        $faqs = [
            [
                'title' => 'Title 1',
                'content' => 'Content 1',
            ],
            [
                'title' => 'Title 2',
                'content' => 'Content 2',
            ],
            [
                'title' => 'Title 3',
                'content' => 'Content 3',
            ],
            [
                'title' => 'Title 4',
                'content' => 'Content 4',
            ],
        ];

        $projects = Project::whereIsOpen()->paginate(9)->withQueryString();

        return Inertia::render('Public/Regional/Edition', [
            'query' => $projects,
            'editions' => $editions,
            'articles' => $articles,
            'parteners' => $parteners,
            'registration' => $registration,
            'faqs' => $faqs,
        ]);
    }

    public function regionalEdition()
    {
        $editions = [
            [
                'href' => '1',
                'name' => 'Gale Regionale 2020',
            ],
            [
                'href' => '2',
                'name' => 'Gale Regionale 2021',
            ],
            [
                'href' => '3',
                'name' => 'Gale Regionale 2022',
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
            'end' => '2023-07-20',
        ];

        $parteners = [
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
            '/images/project_img.png',
        ];

        $faqs = [
            [
                'title' => 'Title 1',
                'content' => 'Content 1',
            ],
            [
                'title' => 'Title 2',
                'content' => 'Content 2',
            ],
            [
                'title' => 'Title 3',
                'content' => 'Content 3',
            ],
            [
                'title' => 'Title 4',
                'content' => 'Content 4',
            ],
        ];

        $edition = [
            'name' => 'Nume',
            'start' => '2023-06-01',
            'end' => '2023-07-20',
            'status' => 'in-progress',
        ];

        $projects = Project::whereIsOpen()->paginate(9)->withQueryString();

        return Inertia::render('Public/Regional/Edition', [
            'query' => $projects,
            'editions' => $editions,
            'edition' => $edition,
            'articles' => $articles,
            'parteners' => $parteners,
            'registration' => $registration,
            'faqs' => $faqs,
        ]);
    }

    public function project(Project $project)
    {
        $gallery = [
            [
                'src' => 'https://youtu.be/f-t2nWVauSE',
                'type' => 'video',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => 'https://youtu.be/f-t2nWVauSE',
                'type' => 'video',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => 'https://youtu.be/f-t2nWVauSE',
                'type' => 'video',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => 'https://youtu.be/f-t2nWVauSE',
                'type' => 'video',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => 'https://youtu.be/f-t2nWVauSE',
                'type' => 'video',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'video',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'video',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'video',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
            [
                'src' => '/images/project_img.png',
                'type' => 'image',
            ],
        ];

        return Inertia::render('Public/Regional/Project', [
            'project' => $project,
            'gallery' => $gallery,
        ]);
    }

    public function regionalRules()
    {
        return Inertia::render('Public/Regional/Rules', [
            'content' => [
                'title' => 'Reguli Gale regionale',
                'subtitle' => 'Subtitle',
                'body' => '<div>body</div>',
            ],
        ]);
    }
}
