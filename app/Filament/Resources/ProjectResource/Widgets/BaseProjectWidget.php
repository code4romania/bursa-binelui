<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Widgets;

use App\Enums\ProjectStatus;
use App\Filament\Resources\ProjectResource;
use App\Models\Project;
use Filament\Tables\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class BaseProjectWidget extends BaseWidget
{
    //    protected static string $view = 'filament.resources.project-resource.widgets.new-project';
    protected static ?int $sort = 1;

    /** @var string */
    protected static string $resource = ProjectResource::class;

    protected int|string|array $columnSpan = [
        'lg' => 2,
    ];

    protected static ?string $recordTitleAttribute = 'title';

    public static function canView(): bool
    {
        return true;
    }

    protected function getTableHeading(): string
    {
        return __('project.heading.approved');
    }

    protected function getTableQuery(): Builder
    {
        return Project::query();
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'new_project';
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'id';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableColumns(): array
    {
        return ProjectResource::getWidgetColumns();
    }

    protected function getTableFilters(): array
    {
        return ProjectResource::getWidgetFilters();
    }

    protected function getTableRecordUrlUsing(): \Closure
    {
        return function (Project $record) {
            return route('filament.resources.projects.view', $record);
        };
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('edit')
                ->label(__('project.actions.edit'))
                ->url(self::getTableRecordUrlUsing())
                ->size('sm')
                ->icon(null),
            Action::make('accept')
                ->label(__('project.actions.approve'))
                ->size('sm')
                ->icon(null)
                ->action(function (Project $record) {
                    $record->status = ProjectStatus::approved->value;
                    $record->save();
                })
                ->requiresConfirmation(),
            Action::make('reject')
                ->label(__('project.actions.reject'))
                ->action(function (Project $record) {
                    $record->status = ProjectStatus::rejected->value;
                    $record->save();
                })
                ->requiresConfirmation()
                ->size('sm')
                ->icon(null),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->paginate(
            $this->getTableRecordsPerPage() == -1 ? $query->count() : $this->getTableRecordsPerPage(),
            ['*'],
            $this->getTablePaginationPageName(),
        );
    }

    protected function getTableHeaderActions(): array
    {
        return [
            ProjectResource\Actions\ExportAction::make($this->getTableQueryStringIdentifier()),
        ];
    }
}
