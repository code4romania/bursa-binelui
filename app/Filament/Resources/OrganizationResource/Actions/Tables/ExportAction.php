<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Tables;

use App\Filament\Exports\ExcelExportWithNotificationInDB;
use App\Filament\Resources\OrganizationResource;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
        $status = $this->name ?? '';

        $this->exports([
            ExcelExportWithNotificationInDB::make()
                ->withFilename(fn () => sprintf(
                    '%s-%s-%s',
                    now()->format('Y_m_d-H_i_s'),
                    Str::slug(OrganizationResource::getPluralModelLabel()),
                    $this->status
                ))
                ->modifyQueryUsing(function (Builder $query) use ($status) {
                    return $query
                        ->status($status)
                        ->with([
                            'activityDomains',
                            'counties',
                            'projects' => fn ($q) => $q->select('id', 'organization_id', 'status')
                                ->withCount('donations'),
                            'users' => fn ($q) => $q->select('organization_id', 'name', 'role')
                                ->onlyOrganizationAdmins(),
                        ])
                        ->withCount([
                            'volunteers',
                        ]);
                })
                ->withColumns([
                    Column::make('id')
                        ->heading('ID'),

                    Column::make('name')
                        ->heading(__('organization.labels.name')),

                    Column::make('status')
                        ->heading(__('organization.labels.status')),

                    Column::make('cif')
                        ->heading(__('organization.labels.cif')),

                    Column::make('description')
                        ->heading(__('organization.labels.description')),

                    Column::make('activity_domains')
                        ->heading(__('organization.labels.activity_domains'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->activityDomains
                                ->pluck('name')
                                ->join(', ')
                        ),

                    Column::make('users')
                        ->heading(__('organization.labels.admin'))
                        ->formatStateUsing(
                            fn (Collection $state) => $state->pluck('name')
                                ->join(', ')
                        ),

                    Column::make('contact_person')
                        ->heading(__('organization.labels.contact_person')),

                    Column::make('contact_phone')
                        ->heading(__('organization.labels.contact_phone')),

                    Column::make('contact_email')
                        ->heading(__('organization.labels.contact_email')),

                    Column::make('website')
                        ->heading(__('organization.labels.website')),

                    Column::make('address')
                        ->heading(__('organization.labels.address')),

                    Column::make('counties')
                        ->heading(__('organization.labels.counties'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->counties
                                ->pluck('name')
                                ->join(', ')
                        ),

                    Column::make('accepts_volunteers')
                        ->heading(__('organization.labels.accepts_volunteers'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->accepts_volunteers
                                ? __('forms::components.select.boolean.true')
                                : __('forms::components.select.boolean.false')
                        ),

                    Column::make('has_volunteers')
                        ->heading(__('organization.labels.has_volunteers'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->volunteers_count
                                ? __('forms::components.select.boolean.true')
                                : __('forms::components.select.boolean.false')
                        ),

                    Column::make('projects_count')
                        ->heading(__('organization.labels.projects_count'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->projects
                                ->count()
                        ),

                    Column::make('active_projects_count')
                        ->heading(__('organization.labels.active_projects_count'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->projects()
                                ->whereIsOpen()
                                ->count()
                        ),

                    Column::make('has_projects')
                        ->heading(__('organization.labels.has_projects'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->projects->count()
                                ? __('forms::components.select.boolean.true')
                                : __('forms::components.select.boolean.false')
                        ),

                    Column::make('has_active_projects')
                        ->heading(__('organization.labels.has_active_projects'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->projects()->whereIsOpen()->count()
                                ? __('forms::components.select.boolean.true')
                                : __('forms::components.select.boolean.false')
                        ),

                    Column::make('has_eu_platesc')
                        ->heading(__('organization.labels.has_eu_platesc'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->eu_platesc_merchant_id !== null && $record->eu_platesc_private_key !== null
                                ? __('forms::components.select.boolean.true')
                                : __('forms::components.select.boolean.false')
                        ),

                    Column::make('has_donations')
                        ->heading(__('organization.labels.has_donations'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->projects->sum('donations_count')
                                ? __('forms::components.select.boolean.true')
                                : __('forms::components.select.boolean.false')
                        ),

                    Column::make('donations_count')
                        ->heading(__('organization.labels.donations_count'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->donations()
                                ->count()
                        ),

                    Column::make('donations_amount')
                        ->heading(__('organization.labels.donations_amount'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->donations()
                                ->sum('amount')
                        ),

                ])
                ->queue(),
        ]);
    }
}
