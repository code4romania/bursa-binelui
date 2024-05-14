<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ProjectStatus;
use App\Enums\UserRole;
use App\Models\GalaProject;
use App\Models\Project;
use App\Models\RegionalProject;
use App\Models\User;
use App\Notifications\Admin\ProjectCreated as ProjectCreatedAdmin;
use App\Notifications\Ngo\ProjectCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Spatie\Image\Image;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProjectService
{
    private Project|GalaProject $project;

    public function __construct($projectClass = null)
    {
        if ($projectClass !== null) {
            $projectClass = new $projectClass;
            $this->project = $projectClass;
        }
    }

    private static function updateGallery(Project $project, ?array $value): void
    {
        $mediaIds = collect($value)
            ->filter(fn ($item) => \is_array($item))
            ->pluck('id');

        $project->getMedia('gallery')
            ->map(function (Media $media) use ($mediaIds) {
                if (! $mediaIds->contains($media->id)) {
                    $media->delete();
                }
            });
        collect($value)->filter(fn ($image) => ! \is_array($image))
            ->map(function ($image) use ($project) {
                $tmpImage = Image::load($image->getPathname());

                $width = $tmpImage->getWidth();
                $height = $tmpImage->getHeight();
                $project->addMedia($image)
                    ->withCustomProperties($width || $height ? compact('width', 'height') : [])
                    ->toMediaCollection('gallery');
            });
    }

    public function create(array $data): Project|GalaProject
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

        if (! empty($data['preview'])) {
            $project->addMedia($data['preview'])->toMediaCollection('preview');
        }

        if (! empty($data['gallery'])) {
            collect($data['gallery'])->map(function ($image) use ($project) {
                $tmpImage = Image::load($image->getPathname());

                $width = $tmpImage->getWidth();
                $height = $tmpImage->getHeight();
                $project->addMedia($image)
                    ->withCustomProperties($width || $height ? compact('width', 'height') : [])
                    ->toMediaCollection('gallery');
            });
        }

        return $project;
    }

    private function createDraftProject(array $data): Project|GalaProject
    {
        if (empty($data['name'])) {
            $data['name'] = 'Draft-' . date('Y-m-d H:i:s') . '-' . auth()->user()->name;
        }
        $slug = \Str::slug($data['name']);
        $count = Project::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $data['slug'] = $slug;
        if ($count > 0) {
            $data['slug'] .= '-' . ($count + 1);
        }
        $data['organization_id'] = auth()->user()->organization_id;

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
    public function changeStatus(Project|GalaProject $project, string $status): void
    {
        match ($status) {
            ProjectStatus::pending->value => $this->pending($project),
            ProjectStatus::archived->value => $this->archive($project),
            default => Log::error('Invalid status  on change project status [# %s ]: %s', $project->id, $status),
        };
    }

    public static function update(Project $project, array $attributes)
    {
        $attributes = collect($attributes);

        $key = $attributes->keys()->first();
        $value = $attributes->get($key);

        return match ($key) {
            'counties' => $project->counties()->sync($value),
            'categories' => $project->categories()->sync($value),
            'image' => $project->addMedia($value)->toMediaCollection('preview'),
            'gallery' => self::updateGallery($project, $value),

            default => ($project->status === ProjectStatus::approved && \in_array($key, $project->requiresApproval))
                ? $project->fill($attributes->all())->saveForApproval()
                : $project->update($attributes->all()),
        };
    }

    private function pending(Project|GalaProject $project)
    {
        $this->project = $project;
        $this->project->status = ProjectStatus::pending->value;
        $this->project->status_updated_at = now();
        $this->project->save();
        $this->sendCreateNotifications($this->project);
    }

    private function archive(Project|GalaProject $project): void
    {
        $this->project = $project;
        $this->project->status_updated_at = now();
        $this->project->archived_at = now();
        $this->project->save();
    }
}
