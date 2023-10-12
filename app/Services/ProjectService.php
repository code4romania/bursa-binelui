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
        $data['slug'] = \Str::slug($data['name']);

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

    /**
     * @throws \Exception
     */
    public function changeStatus($id, string $status): void
    {
        $this->project = $this->project::findOrFail($id);
        match ($status) {
            ProjectStatus::draft->value => $this->project->update(['status' => $status]),
            ProjectStatus::pending->value => $this->createPendingProject($this->project->toArray()),
        };
        if ($this->project->status === ProjectStatus::draft && $status === ProjectStatus::pending->value) {
            $fields = $this->project->toArray();
            $requiredFields = $this->project->getRequiredFieldsForApproval();
            $missingFields = [];
            foreach ($fields as $key => $value) {
                if (\in_array($key, $requiredFields) && empty($value)) {
                    $missingFields[] = $key;
                }
            }
            if (! empty($missingFields)) {
                throw new ('Project is missing required fields for approval, please fill in all required fields . Please fill: ' . implode(', ', $missingFields));
            }
        }
        $this->project->update(['status' => $status]);
        if ($status === ProjectStatus::approved->value) {
            $this->sendCreateNotifications($this->project);
        }
    }
}
