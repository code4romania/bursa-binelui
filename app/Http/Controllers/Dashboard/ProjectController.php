<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\EditRequest;
use App\Http\Requests\Project\StatusChangeRequest;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Resources\Project\EditProjectResource;
use App\Http\Resources\ProjectCardResource;
use App\Models\Activity;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
                    ->orderBy('status_updated_at')
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

        return redirect()->route('dashboard.projects.edit', $project->id)->with('success', 'Project created.');
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        $project->load('media');

        return Inertia::render('AdminOng/Projects/EditProject', [
            'project' => new EditProjectResource($project),
            'counties' => $this->getCounties(),
            'projectCategories' => $this->getProjectCategories(),
            'changes' => Activity::pendingChangesFor($project)
                ->get()
                ->flatMap(fn (Activity $activity) => $activity->properties)
                ->unique(),
        ]);
    }

    public function update(EditRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        ProjectService::update($project, $request->validated());

        return redirect()->back()
            ->with('success', __('project.project_updated'));
    }

    public function changeStatus(StatusChangeRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        (new ProjectService(Project::class))->changeStatus($project, $request->get('status'));

        return redirect()->back()
            ->with('success', __('project.project_status_changed.'));
    }
}
