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
use Illuminate\Support\Facades\Notification;

class ProjectService
{
    private Project|RegionalProject $project;
    public function __construct($projectClass)
    {
        $this->project = new $projectClass;
    }

    public function create(array $data): Project|RegionalProject
    {
        $data['organization_id'] = auth()->user()->organization_id;
        $data['status'] = $data['project_status'];
        if ($data['project_status'] === ProjectStatus::draft->value) {
            $project = $this->createDraftProject($data);
        } else {
            $project = $this->createPendingProject($data);
        }

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
            $data['slug'] = \Str::slug($data['name']);
        }

        return  $this->project::create($data);
    }

    private function sendCreateNotifications($project): void
    {
        auth()->user()->notify(new ProjectCreated($project));
        $adminUsers = User::whereRole(UserRole::bb_admin)->get();
        Notification::send($adminUsers, new ProjectCreatedAdmin($project));
    }

    private function createPendingProject(array $data): Project|RegionalProject
    {
        $data['slug'] = \Str::slug($data['name']);
        $project = $this->project::create($data);
        $this->sendCreateNotifications($project);

        return $project;
    }
}
