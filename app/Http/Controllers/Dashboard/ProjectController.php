<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Resources\Project\EditProjectResource;
use App\Http\Resources\ProjectCardResource;
use App\Models\Activity;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projectStatus = $request->get('project_status');

        return Inertia::render('AdminOng/Projects/Projects', [
            'query' => ProjectCardResource::collection(
                Project::query()
                    ->where('organization_id', auth()->user()->organization_id)
                    ->when($projectStatus, function (Builder $query) use ($projectStatus) {
                        return $query->statusIs($projectStatus);
                    })
                    ->paginate(16)
                    ->withQueryString()
            ),
            'projectStatus' => $projectStatus,
        ]);
    }

    public function create()
    {
        return Inertia::render('AdminOng/Projects/AddProject', [
            'counties' => $this->getCounties(),
            'projectCategories' => $this->getProjectCategories(),
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $project = (new ProjectService(Project::class))->create($data);
        $project->addAllMediaFromRequest()->each(function ($fileAdder, $index) {
            if ($index == 0) {
                $fileAdder->toMediaCollection('preview');
            } else {
                $fileAdder->toMediaCollection('gallery');
            }
        });

        return redirect()->route('dashboard.projects.edit', $project->id)->with('success', 'Project created.');
    }

    public function edit(Project $project)
    {
        $this->authorize('view', $project);
        $project->load('media');

        return Inertia::render('AdminOng/Projects/EditProject', [
            'project' => new EditProjectResource($project),
            'counties' => $this->getCounties(),
            'projectCategories' => $this->getProjectCategories(),
            'changes' => Activity::pendingChangesFor($project)
                ->get()
                ->flatMap(fn (Activity $activity) => $activity->properties->keys())
                ->unique()
                ->values(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('editAsNgo', $project);
        ProjectService::update($project, $request->all());

        return redirect()->back()
            ->with('success', 'Project updated.');

//        if ($request->has('counties')) {
//            $project->counties()->sync(collect($request->get('counties')));
//        }
//        if ($request->has('categories')) {
//            $project->categories()->sync(collect($request->get('categories')));
//        }
        ////        dd($request->all());
//        if ($request->has('image')) {
//            $project->addMediaFromRequest('image')->toMediaCollection('preview');
//        }
//        $project->update($request->all());
    }

    public function changeStatus($id, Request $request)
    {
        $project = Project::findOrFail($id);
        $projectArray = $project->toArray();
        $projectArray['preview'] = $project->getFirstMedia('preview');
        Validator::make(
            $projectArray,
            [
                'name' => ['required', 'max:255'],
                'start' => ['required', 'date', 'after_or_equal:today'],
                'end' => ['required', 'date', 'after:start'],
                'target_budget' => ['required', 'numeric', 'min:1'],
                'categories' => ['required', 'array', 'min:1'],
                'counties' => ['required_if:is_national,0', 'array', 'min:1'],
                'description' => ['required', 'min:100', 'max:1000'],
                'scope' => ['required', 'min:100', 'max:1000'],
                'beneficiaries' => ['required', 'min:100', 'max:1000'],
                'reason_to_donate' => ['required', 'min:100', 'max:1000'],
                'preview' => ['required'],
            ],
            [
                'start.after_or_equal' => __('custom_validation.start_date.after_or_equal'),
            ]
        )->validate();

        try {
            (new ProjectService(Project::class))->changeStatus($project, $request->get('status'));
        } catch (\Exception $exception) {
            dd($exception->getMessage());

            return redirect()->back()
                ->with('error', $exception->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Project status changed.');
    }
}
