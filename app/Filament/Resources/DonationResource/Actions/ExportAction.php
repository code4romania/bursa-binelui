<?php

declare(strict_types=1);

namespace App\Filament\Resources\DonationResource\Actions;

use App\Filament\Exports\ExcelExportWithNotificationInDB;
use App\Filament\Resources\DonationResource;
use App\Models\Donation;
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

        $this->exports([
            ExcelExportWithNotificationInDB::make()
                ->withFilename(fn () => sprintf(
                    '%s-%s',
                    now()->format('Y_m_d-H_i_s'),
                    Str::slug(DonationResource::getPluralModelLabel()),
                ))
                ->fromTable()

                ->withColumns([
                    Column::make('id')
                        ->heading('ID'),

                    Column::make('organization.name')
                        ->formatStateUsing(fn ($state) => Str::upper($state))
                        ->heading(__('organization.label.singular')),

                    Column::make('project.name')
                        ->formatStateUsing(fn ($state) => Str::upper($state))
                        ->heading(__('project.label.singular')),

                    Column::make('full_name')
                        ->formatStateUsing(fn ($state) => Str::upper($state))
                        ->heading(__('donation.labels.full_name')),

                    Column::make('amount')
                        ->heading(__('donation.labels.amount')),

                    Column::make('created_at')
                        ->formatStateUsing(fn (Donation $record) => $record->created_at->toFormattedDateTime())
                        ->heading(__('donation.labels.created_at')),

                    Column::make('updated_at')
                        ->formatStateUsing(fn (Donation $record) => $record->updated_at?->toFormattedDateTime())
                        ->heading(__('donation.labels.status_updated_at')),

                    Column::make('status')
                        ->formatStateUsing(fn (Donation $record) => $record->status->label())
                        ->heading(__('donation.labels.status')),

                ])
                ->queue(),
        ]);
    }
}
