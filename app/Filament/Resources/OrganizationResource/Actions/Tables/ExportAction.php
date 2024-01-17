<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Tables;

use App\Enums\OrganizationStatus;
use App\Filament\Resources\OrganizationResource;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction as BaseAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExportAction extends BaseAction
{
    protected string | null $status = null;

    public function status(OrganizationStatus | string | null $status): static
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
                    Str::slug(OrganizationResource::getPluralModelLabel()),
                    $this->status
                ))
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->status($this->status)
                        ->with([
                            'activityDomains',
                            'counties',
                            'projects' => fn ($q) => $q->select('id', 'organization_id', 'status')
                                ->withCount('donations'),
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

                    Column::make('cif')
                        ->heading(__('organization.labels.cif')),

                    Column::make('activity_domains')
                        ->heading(__('organization.labels.activity_domains'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->activityDomains
                                ->pluck('name')
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

                ]),
        ]);
    }
}
