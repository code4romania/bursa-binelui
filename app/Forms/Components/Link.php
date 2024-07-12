<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Filament\Resources\OrganizationResource;
use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Forms\Components\Field;
use Illuminate\Support\Collection;

class Link extends Field
{
    protected string $view = 'forms.components.user-link';

    protected string $type = 'user';

    public function getUsers(): Collection
    {
        return $this->getRecord()
            ->users
            ->map(fn (User $user) => [
                'name' => $user->name,
                'url' => UserResource::getUrl('view', $user),
            ]);
    }

    public function getOrganization(): Collection
    {
        return collect([])->push(['name' => $this->getRecord()->organization?->name, 'url' => OrganizationResource::getUrl('view', $this->getRecord()->organization)]);
    }

    public function getProject(): Collection
    {
        return collect([])->push(['name' => $this->getRecord()->project->name, 'url' => ProjectResource::getUrl('view', $this->getRecord()->project)]);
    }

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getLinks(): Collection
    {
        if ($this->type === 'user') {
            return $this->getUsers();
        }

        return match ($this->type) {
            'user' => $this->getUsers(),
            'organization' => $this->getOrganization(),
            'project' => $this->getProject(),
        };
    }
}
