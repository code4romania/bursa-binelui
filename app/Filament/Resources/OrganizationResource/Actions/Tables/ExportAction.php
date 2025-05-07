<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Tables;

use App\Enums\UserRole;
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
    protected string|null $status = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('secondary');
        $status = $this->name ?? '';

        $this->exports([
            ExcelExportWithNotificationInDB::make()
                ->fromTable()
                ->withFilename(fn () => sprintf(
                    '%s-%s-%s',
                    now()->format('Y_m_d-H_i_s'),
                    Str::slug(OrganizationResource::getPluralModelLabel()),
                    $this->status
                ))
                ->modifyQueryUsing(function (Builder $query) use ($status) {
                    return $query
                        ->addSelect(['accepts_volunteers', 'eu_platesc_merchant_id', 'eu_platesc_private_key', 'cif', 'description', 'address', 'contact_person', 'contact_phone', 'contact_email', 'website', 'facebook'])
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
                        ->formatStateUsing(fn (Organization $record) => $record->status->label())
                        ->heading(__('organization.labels.status')),

                    Column::make('accepts_donations')
                        ->heading(__('organization.labels.accepts_donations'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->accept_donations
                                ? __('forms::components.select.boolean.true')
                                : __('forms::components.select.boolean.false')
                        ),

                    Column::make('counties')
                        ->heading(__('organization.labels.counties'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->counties
                                ->pluck('name')
                                ->join(', ')
                        ),
                    Column::make('description')
                        ->heading(__('organization.labels.description')),

                    Column::make('activity_domains')
                        ->heading(__('organization.labels.activity_domains'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->activityDomains
                                ->pluck('name')
                                ->join(', ')
                        ),

                    Column::make('cif')
                        ->heading(__('organization.labels.cif')),

                    Column::make('statute')
                        ->heading(__('organization.labels.statute'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->has_statute
                                ? $record->statute_file
                                : __('forms::components.select.boolean.false')
                        ),

                    Column::make('website')
                        ->heading(__('organization.labels.website')),

                    Column::make('address')
                        ->heading(__('organization.labels.address')),

                    Column::make('contact_phone')
                        ->heading(__('organization.labels.contact_phone')),

                    Column::make('contact_email')
                        ->heading(__('organization.labels.contact_email')),

                    Column::make('contact_person')
                        ->heading(__('organization.labels.contact_person')),

                    Column::make('users')
                        ->heading(__('organization.labels.admin_count'))
                        ->formatStateUsing(
                            fn (Collection $state) => $state->filter(
                                fn ($record) => $record->role !== UserRole::ADMIN->value
                            )->count()
                        ),

                    Column::make('accepts_volunteers')
                        ->heading(__('organization.labels.accepts_volunteers'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->accepts_volunteers
                                ? __('forms::components.select.boolean.true')
                                : __('forms::components.select.boolean.false')
                        ),

                    Column::make('projects_count')
                        ->heading(__('organization.labels.projects_count'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->projects()
                                ->count()
                        ),

                    Column::make('active_projects_count')
                        ->heading(__('organization.labels.active_projects_count'))
                        ->formatStateUsing(
                            function (Organization $record) {
                                $count = $record->projects()
                                    ->whereIsOpen()
                                    ->count();

                                return $count > 0 ?
                                    $count :
                                    '0';
                            }
                        ),

                    Column::make('donations_count')
                        ->heading(__('organization.labels.donations_count'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->donations()
                                ->whereCharged()
                                ->count()
                        ),

                    Column::make('donations_amount')
                        ->heading(__('organization.labels.donations_amount'))
                        ->formatStateUsing(
                            fn (Organization $record) => $record->donations()
                                ->whereCharged()
                                ->sum('charge_amount')
                        ),

                ])
                ->queue(),
        ]);
    }
}
