<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\ProjectResource\Widgets\ApprovedProject;
use App\Filament\Resources\ProjectResource\Widgets\NewProject;
use App\Filament\Resources\ProjectResource\Widgets\PendingChangesProjectWidget;
use App\Filament\Resources\ProjectResource\Widgets\RejectedProject;
use Filament\Resources\Pages\Page;

class ProjectIndex extends Page
{
    protected static string $resource = ProjectResource::class;

    protected static ?string $title = '';

    protected static string $view = 'filament.resources.project-resource.pages.project-index';

    protected function getHeaderWidgets(): array
    {
        return [
            NewProject::class,
            PendingChangesProjectWidget::class,
            ApprovedProject::class,
            RejectedProject::class,
        ];
    }
}
