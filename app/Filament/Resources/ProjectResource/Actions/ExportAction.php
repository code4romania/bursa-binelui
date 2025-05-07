<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Actions;

use App\Filament\Exports\ExcelExportWithNotificationInDB;
use App\Filament\Resources\ProjectResource;
use App\Models\Activity;
use App\Models\County;
use App\Models\Organization;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction as BaseAction;
use pxlrbt\FilamentExcel\Columns\Column;

class ExportAction extends BaseAction
{
    protected string | null $status = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('secondary');

        $fileName = sprintf(
            '%s-%s',
            now()->format('Y_m_d-H_i_s'),
            Str::slug(ProjectResource::getPluralModelLabel()),
        );
        $name = $this->name;
        $this->exports([
            ExcelExportWithNotificationInDB::make()
                ->withFilename($fileName)
                ->fromTable()
                ->modifyQueryUsing(
                    function (Builder $query) use ($name) {
                        if ($name == 'approved_project') {
                            $query->whereIsApproved();
                        }

                        if ($name == 'new_project') {
                            $query->whereIsPending();
                        }

                        if ($name == 'pending_changes') {
                            $query->withCount([
                                'activities' => fn (Builder $query) => $query->wherePending(),
                            ])
                                ->whereHas('activities', function (Builder $query) {
                                    $query->wherePending();
                                })
                                ->addSelect([
                                    'latest_updated_at' => Activity::query()
                                        ->withoutGlobalScopes()
                                        ->wherePending()
                                        ->select('created_at')
                                        ->whereColumn('subject_id', 'projects.id')
                                        ->whereMorphedTo('subject', Organization::class)
                                        ->latest()
                                        ->take(1),
                                ]);
                        }

                        if ($name == 'rejected_project') {
                            $query->whereIsRejected();
                        }

                        return $query;
                    }
                )
                ->withColumns([
                    Column::make('name')
                        ->heading(__('project.labels.name')),

                    Column::make('status')
                        ->heading(__('project.labels.status')),

                    Column::make('organization')
                        ->heading(__('project.labels.organization'))
                        ->formatStateUsing(
                            fn (Project $record, $state) => $state->name
                        ),

                    Column::make('start')
                        ->heading(__('project.labels.start'))
                        ->formatStateUsing(
                            fn (Project $record, $state) => $state?->toFormattedDateTime()
                        ),

                    Column::make('end')
                        ->heading(__('project.labels.end'))
                        ->formatStateUsing(
                            fn (Project $record, $state) => $state?->toFormattedDateTime()
                        ),

                    Column::make('counties')
                        ->heading(__('project.labels.counties'))
                        ->formatStateUsing(
                            fn (Project $record) => $record->counties->map(fn (County $county) => $county->name)
                                ->join(', ')
                        ),

                    Column::make('category')
                        ->heading(__('project.labels.category'))
                        ->formatStateUsing(
                            fn (Project $record, $state) => $record->categories->map(fn (ProjectCategory $category) => $category->name)
                                ->join(', ')
                        ),

                    Column::make('description')
                        ->heading(__('project.labels.description')),

                    Column::make('scope')
                        ->heading(__('project.labels.scope')),

                    Column::make('target_budget')
                        ->heading(__('project.labels.target_budget')),

                    Column::make('beneficiaries')
                        ->heading(__('project.labels.beneficiaries')),

                    Column::make('reason_to_donate')
                        ->heading(__('project.labels.reason_to_donate')),

                    Column::make('accepting_volunteers')
                        ->heading(__('project.labels.accepting_volunteers'))
                        ->formatStateUsing(fn (Project $record, $state) => $state ? __('field.boolean.true') : __('field.boolean.false')),

                    Column::make('accepting_comments')
                        ->heading(__('project.labels.accepting_comments'))
                        ->formatStateUsing(fn (Project $record, $state) => $state ? __('field.boolean.true') : __('field.boolean.false')),

                    Column::make('donation_number')
                        ->heading(__('donation.labels.count'))
                        ->formatStateUsing(
                            fn (Project $record) => $record->loadMissing('donations')->donations->count()
                        ),

                    Column::make('donation_amount')
                        ->heading(__('donation.labels.amount'))
                        ->formatStateUsing(
                            fn (Project $record) => $record->loadMissing('donations')->donations()->sum('amount'),
                        ),
                ])
                ->queue(),
        ]);
    }
}
