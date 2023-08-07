<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Resources\Pages\Page;

class ProjectIndex extends Page
{
    protected static string $resource = ProjectResource::class;

    protected static ?string $title = '';

    protected static string $view = 'filament.resources.project-resource.pages.project-index';

    protected function getHeaderWidgets(): array
    {
        return [
            ProjectResource\Widgets\NewProject::class,
            ProjectResource\Widgets\ApprovedProject::class,
            ProjectResource\Widgets\RejectedProject::class,
        ];
    }
}
