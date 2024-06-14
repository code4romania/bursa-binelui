<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Enums\EuPlatescStatus;
use App\Filament\Forms\Components\Value;
use App\Models\Donation;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Number;

class DonationsRelationManager extends RelationManager
{
    protected static string $relationship = 'donations';

    protected static ?string $recordTitleAttribute = 'uuid';

    public static function getTitle(): string
    {
        return __('donation.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Value::make('full_name')
                    ->label(__('donation.labels.full_name')),

                Value::make('email')
                    ->label(__('donation.labels.email')),

                Value::make('amount')
                    ->label(__('donation.labels.amount'))
                    ->content(fn (Donation $record) => Number::currency($record->amount, 'RON', app()->getLocale())),

                Value::make('status')
                    ->label(__('donation.labels.status')),

                Value::make('created_at')
                    ->label(__('donation.labels.created_at'))
                    ->withTime(),

                Value::make('charge_date')
                    ->label(__('donation.labels.charge_date'))
                    ->withTime(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('donation.labels.full_name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label(__('donation.labels.amount'))
                    ->formatStateUsing(fn ($state) => Number::currency($state, 'RON', app()->getLocale()))
                    ->sortable()
                    ->alignRight(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('donation.labels.status'))
                    ->formatStateUsing(fn ($state) => EuPlatescStatus::tryFrom($state)?->label()),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('donation.labels.created_at'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('charge_date')
                    ->label(__('donation.labels.charge_date'))
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
