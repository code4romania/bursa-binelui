<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\ChampionshipStageProject;
use App\Models\County;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChampionshipController extends Controller
{
    public function index()
    {
        $championship = Championship::current()->firstOrFail();
        $projects = $championship->activeStage()->projects()->paginate()->withQueryString()->through(fn ($project) =>$project->project);
        $projectAmount = $championship->activeStage()->projects()->sum('amount_of_donation');
        $projectDonationsNumber = $championship->activeStage()->projects()->sum('number_of_donation');
        $counties = County::get(['name', 'id']);
        $testimonials = $championship->testimonials;
        $stages = $championship->stages;
        $articles = $championship->articles;
        $links = [];

        return Inertia::render('Public/Championship/Championship', [
            'projects' => $projects,
            'projectAmount' => $projectAmount,
            'projectDonationsNumber' => $projectDonationsNumber,
            'counties' => $counties,
            'testimonials' => $testimonials,
            'championship' => $championship,
            'links' => $links,
            'editions' => $stages,
            'articles' => $articles,
        ]);
    }

    public function edition()
    {
        $testimonials = [
            [
                'content' => '11111 Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo expedita voluptas culpa sapiente alias molestiae. Numquam corrupti in laborum sed rerum et corporis.',
                'name' => 'Judith Black',
                'job' => 'CEO',
                'company' => 'Workcation',
            ],
            [
                'content' => '222222222 Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo expedita voluptas culpa sapiente alias molestiae. Numquam corrupti in laborum sed rerum et corporis.',
                'name' => 'Judith Black',
                'job' => 'CEO',
                'company' => 'Workcation',
            ],
        ];

        $links = [
            [
                'href' => '#',
                'label' => 'Titlu Articol',
                'source' => 'sursa.ro',
            ],
            [
                'href' => '#',
                'label' => 'Titlu Articol',
                'source' => 'sursa.ro',
            ],
            [
                'href' => '#',
                'label' => 'Titlu Articol',
                'source' => 'sursa.ro',
            ],
        ];

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

        $statistics = [
            [
                'month' => 'Decembrie 2016',
                'donations' => '2210',
                'amount' => '188873,00',
            ],
            [
                'month' => 'Decembrie 2016',
                'donations' => '2210',
                'amount' => '188873,00',
            ],
            [
                'month' => 'Decembrie 2016',
                'donations' => '2210',
                'amount' => '188873,00',
            ],
            [
                'month' => 'Decembrie 2016',
                'donations' => '2210',
                'amount' => '188873,00',
            ],
        ];

        $projects = Project::whereIsOpen()->paginate(9)->withQueryString();
        $counties = County::get(['name', 'id']);

        return Inertia::render('Public/Championship/Edition', [
            'query' => $projects,
            'counties' => $counties,
            'testimonials' => $testimonials,
            'links' => $links,
            'editions' => $editions,
            'articles' => $articles,
            'statistics' => $statistics,
        ]);
    }

    public function projects(Request $request)
    {
        $offset = ($request->page - 1) * 8;

        return auth()->user()?->organization
            ->projects()
//            ->notInChampionship($request->championship_id)
            ->whereIsOpen()
            ->offset($offset)->limit(8)->get();
    }

    public function subscribeProject(Request $request)
    {
        if (auth()->check()) {
            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'championship_id' => 'required|exists:championships,id',
                'stage_id' => 'required|exists:championship_stages,id',
            ]);
            ChampionshipStageProject::create(
                [
                    'project_id' => $request->project_id,
                    'championship_id' => $request->championship_id,
                    'championship_stage_id' => $request->stage_id,
                ]
            );

            return response()->json(['message' => 'success']);
        }

        return response()->json(['message' => 'error']);
    }

    public function championshipRules()
    {
        return Inertia::render('Public/Championship/Rules', [
            'content' => [
                'title' => 'Reguli Gale regionale',
                'subtitle' => 'Subtitle',
                'body' => '<div>body</div>',
            ],
        ]);
    }
}
