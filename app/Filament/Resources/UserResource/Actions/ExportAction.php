<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Actions;

use App\Enums\EuPlatescStatus;
use App\Filament\Exports\ExcelExportWithNotificationInDB;
use App\Filament\Resources\UserResource;
use App\Models\User;
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

        $this->exports([
            ExcelExportWithNotificationInDB::make()
                ->withFilename(fn () => sprintf(
                    '%s-%s',
                    now()->format('Y_m_d-H_i_s'),
                    Str::slug(UserResource::getPluralModelLabel()),
                ))
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->with([
                            'donations' => fn ($q) => $q->select(['user_id', 'amount', 'status', 'created_at']),
                        ])
                        ->withCount(['donations']);
                })
                ->withColumns([
                    Column::make('id')
                        ->heading('ID'),

                    Column::make('name')
                        ->heading(__('user.labels.name')),

                    Column::make('email')
                        ->heading(__('user.labels.email')),

                    Column::make('role')
                        ->heading(__('user.labels.role'))->formatStateUsing(
                            fn ($state) => $state->label()
                        ),

                    Column::make('status')
                        ->heading(__('user.labels.status'))
                        ->formatStateUsing(
                            fn (User $record) => $record->email_verified_at ?
                                __('user.labels.status_display.verified') :
                                __('user.labels.status_display.unverified')
                        ),

                    Column::make('created_at')
                        ->heading(__('user.labels.created_at'))
                        ->formatStateUsing(
                            fn (User $record) => $record->created_at->toFormattedDateTime()
                        ),

                    Column::make('newsletter_subscription')
                        ->heading(__('user.labels.newsletter_subscription'))
                        ->formatStateUsing(
                            fn (User $record) => $record->newsletter ?
                                    $record->created_at->toFormattedDateTime() :
                                    ''
                        ),

                    Column::make('referrer')
                        ->heading(__('user.labels.referrer')),

                    Column::make('donations')
                        ->heading(__('user.labels.donations_sum'))
                        ->formatStateUsing(
                            fn (User $record) => $record->donations
                                ->reject(fn ($item) => $item->status === EuPlatescStatus::CHARGED)
                                ->sum('amount')
                        ),

                    Column::make('donations_count')
                        ->heading(__('user.labels.donations_count')),

                    Column::make('last_donation_date')
                        ->heading(__('user.labels.last_donation_date'))
                        ->formatStateUsing(
                            fn (User $record) => $record->donations_count ?
                                    $record->donations
                                        ->reject(fn ($item) => $item->status === EuPlatescStatus::CHARGED)
                                        ->last()?->created_at->toFormattedDateTime() : ''
                        ),

                ])
                ->queue(),
        ]);
    }
}
