<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ProjectStatus;
use App\Enums\UserRole;
use App\Models\Project;
use App\Models\RegionalProject;
use App\Models\User;
use App\Notifications\Admin\ProjectCreated as ProjectCreatedAdmin;
use App\Notifications\Ngo\ProjectCreated;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class ProjectService
{
    private Project|RegionalProject $project;

    public function __construct($projectClass = null)
    {
        if ($projectClass !== null) {
            $projectClass = new $projectClass;
            $this->project = $projectClass;
        }
    }

    public function create(array $data): Project|RegionalProject
    {
        $data['organization_id'] = auth()->user()->organization_id;
        $data['status'] = ProjectStatus::draft->value;

        $project = $this->createDraftProject($data);
        if (! empty($data['categories'])) {
            $project->categories()->attach($data['categories']);
        }
        if (! empty($data['counties'])) {
            $project->counties()->attach($data['counties']);
        }

        return $project;
    }

    private function createDraftProject(array $data): Project|RegionalProject
    {
        if (empty($data['name'])) {
            $data['name'] = 'Draft-' . date('Y-m-d H:i:s') . '-' . auth()->user()->name;
        }
        $slug = \Str::slug($data['name']);
        $count = Project::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $data['organization_id'] = auth()->user()->organization_id;
        $data['slug'] = $slug;
        if ($count > 0) {
            $data['slug'] .= '-' . ($count + 1);
        }

        return  $this->project::create($data);
    }

    private function sendCreateNotifications($project): void
    {
        auth()->user()->notify(new ProjectCreated($project));
        $adminUsers = User::whereRole(UserRole::SUPERADMIN)->get();
        Notification::send($adminUsers, new ProjectCreatedAdmin($project));
    }

    private function createPendingProject(array $data): Project|RegionalProject
    {
        $data['slug'] = \Str::slug($data['name']);
        $data['organization_id'] = auth()->user()->organization_id;
        $project = $this->project::create($data);
        $this->sendCreateNotifications($project);

        return $project;
    }

    /**
     * @throws \Exception
     */
    public function changeStatus(Project|RegionalProject $project, string $status): void
    {
        $this->project = $project;
        $this->project->status = ProjectStatus::pending->value;
        $this->project->status_updated_at = now();
        $this->project->save();
        if ($status === ProjectStatus::approved->value) {
            $this->sendCreateNotifications($this->project);
        }
    }

    public static function update(Project $project, array $attributes)
    {
        $attributes = collect($attributes);

        $key = $attributes->keys()->first();
        $value = $attributes->get($key);

        return match ($key) {
            'counties' => $project->counties()->sync($value),
            'activity_domains' => $project->categories()->sync($value),
            'preview' => $project->addMedia($value)->toMediaCollection('preview'),

            default => \in_array($key, $project->requiresApproval)
                ? $project->fill($attributes->all())->saveForApproval()
                : $project->update($attributes->all()),
        };
    }
}
