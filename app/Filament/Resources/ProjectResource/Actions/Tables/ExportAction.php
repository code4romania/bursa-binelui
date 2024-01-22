<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Actions\Tables;

use App\Enums\OrganizationStatus;
use App\Enums\ProjectStatus;
use App\Filament\Resources\OrganizationResource;
use App\Filament\Resources\ProjectResource;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction as BaseAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExportAction extends BaseAction
{
    protected string | null $status = null;

    public function status(ProjectStatus | string | null $status): static
    {
        $this->status = $status?->value ?? $status;

        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('secondary');

        $this->exports([
            ExcelExport::make()
                ->withFilename(fn () => sprintf(
                    '%s-%s-%s',
                    now()->format('Y_m_d-H_i_s'),
                    Str::slug(ProjectResource::getPluralModelLabel()),
                    $this->status
                ))
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->status($this->status)
                        ->with([
                            'counties',
                            'donations'
                        ])
                        ->withCount([
                            'donations',
                        ]);
                })
                ->withColumns([
                    Column::make('id')
                        ->heading('ID'),

                    Column::make('name')
                        ->heading(__('project.labels.name')),

                    Column::make('cif')
                        ->heading(__('project.labels.cif')),

                    Column::make('activity_domains')
                        ->heading(__('project.labels.activity_domains'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->activityDomains
                                ->pluck('name')
                                ->join(', ')
                        ),

                    Column::make('contact_person')
                        ->heading(__('project.labels.contact_person')),

                    Column::make('contact_phone')
                        ->heading(__('project.labels.contact_phone')),

                    Column::make('contact_email')
                        ->heading(__('project.labels.contact_email')),

                    Column::make('website')
                        ->heading(__('project.labels.website')),

                    Column::make('address')
                        ->heading(__('project.labels.address')),

                    Column::make('counties')
                        ->heading(__('project.labels.counties'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->counties
                                ->pluck('name')
                                ->join(', ')
                        ),

                    Column::make('accepts_volunteers')
                        ->heading(__('project.labels.accepts_volunteers'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->accepts_volunteers
                                ? __('forms::components.select.boolean.true')
                                : __('forms::components.select.boolean.false')
                        ),

                    Column::make('has_volunteers')
                        ->heading(__('project.labels.has_volunteers'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->volunteers_count
                                ? __('forms::components.select.boolean.true')
                                : __('forms::components.select.boolean.false')
                        ),

                    Column::make('has_projects')
                        ->heading(__('project.labels.has_projects'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->projects->count()
                                ? __('forms::components.select.boolean.true')
                                : __('forms::components.select.boolean.false')
                        ),

                    Column::make('has_donations')
                        ->heading(__('project.labels.has_donations'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->projects->sum('donations_count')
                                ? __('forms::components.select.boolean.true')
                                : __('forms::components.select.boolean.false')
                        ),

                ]),
        ]);
    }
}
