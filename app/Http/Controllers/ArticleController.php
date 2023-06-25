<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        // $query = Article::query();

        $categories = ['SOCIAL', 'EDUCATIE', 'MEDIU', 'LOREM', 'LOREM IPSUM'];

        $query = [
            'current_page' => 1,
            'data' => [
                [
                    'id' => 1,
                    'title' => 'Importanța educației remediale în România în timpul pandemiei',
                    'content' => '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto accusantium praesentium eius, ut atque fuga culpa, similique sequi cum eos quis dolorum.</p>',
                    'author' => 'Ion Popescu',
                    'ong' => 'Asociatia Pentru Tine',
                    'image' => '/images/project_img.png',
                    'category' => 'SOCIAL',
                    'created_at' => '15.02.2022',
                ],
                [
                    'id' => 2,
                    'title' => 'Importanța educației remediale în România în timpul pandemiei',
                    'content' => '<a href="google.com">Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto accusantium praesentium eius, ut atque fuga culpa, similique sequi cum eos quis dolorum.</a>',
                    'author' => 'Ion Popescu',
                    'ong' => 'Asociatia Pentru Tine',
                    'image' => '/images/project_img.png',
                    'category' => 'SOCIAL',
                    'created_at' => '15.02.2022',
                ],
                [
                    'id' => 3,
                    'title' => 'Importanța educației remediale în România în timpul pandemiei',
                    'content' => '<div><ul><li>unu</li><li>doi</li></ul><img src=""></div>',
                    'author' => 'Ion Popescu',
                    'ong' => 'Asociatia Pentru Tine',
                    'image' => '/images/project_img.png',
                    'category' => 'SOCIAL',
                    'created_at' => '15.02.2022',
                ],
            ],
            'first_page_url' => 'http://bursabinelui.test/articole?page=1',
            'from' => 1,
            'last_page' => 2,
            'last_page_url'=> 'http://bursabinelui.test/articole?page=2',
            'links' => [
                [
                    'url' => 'http://bursabinelui.test/articole?page=1',
                    'label' => '1',
                    'active' => true,
                ],
                [
                    'url'=> 'http://bursabinelui.test/articole?page=2',
                    'label'=> '2',
                    'active'=> false,
                ],
            ],
            'next_page_url'=> 'http://bursabinelui.test/articole?page=1',
            'path'=> 'http://bursabinelui.test/articole',
            'per_page' =>15,
            'prev_page_url' => null,
            'to' => 15,
            'total' => 20,

        ];

        return Inertia::render('Public/Articles/Articles', [
            'categories' => $categories,
            'query' => $query,
        ]);
    }

    public function article(Article $article)
    {
        $article = [
            'id' => 1,
            'title' => 'Importanța educației remediale în România în timpul pandemiei',
            'content' => '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto accusantium praesentium eius, ut atque fuga culpa, similique sequi cum eos quis dolorum.</p>',
            'author' => 'Ion Popescu',
            'ong' => 'Asociatia Pentru Tine',
            'image' => '/images/project_img.png',
            'category' => 'SOCIAL',
            'created_at' => '15.02.2022',
        ];

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

        return Inertia::render('Public/Articles/Article', [
            'article' => $article,
            'gallery' => $gallery,
        ]);
    }
}
