<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\RelationManagers;

use App\Enums\EuPlatescStatus;
use App\Models\Donation;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;

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
                TextInput::make('uuid')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->required()
                    ->maxLength(255),
                TextInput::make('amount')
                    ->required()
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('donation.labels.id'))
                    ->formatStateUsing(fn (Donation $record) => sprintf('#%d', $record->id)),
                TextColumn::make('status')
                    ->label(__('donation.labels.status'))
                    ->formatStateUsing(fn (Donation $record) => $record->status->label()),
                TextColumn::make('project.name')
                    ->label(__('donation.labels.project')),
                TextColumn::make('email')
                    ->label(__('donation.labels.email')),
                TextColumn::make('amount')
                    ->label(__('donation.labels.amount')),
                TextColumn::make('created_at')
                    ->label(__('donation.labels.created_at'))->sortable(),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('donation.labels.status'))
                    ->options(EuPlatescStatus::options())
                    ->multiple(),
                SelectFilter::make('project_id')
                    ->label(__('donation.labels.project'))
                    ->relationship('project', 'name')
                    ->multiple(),
                TernaryFilter::make('has_user')
                    ->label(__('donation.labels.has_user'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('user_id'),
                        false: fn (Builder $query) => $query->whereNull('user_id'),
                    ),
                TernaryFilter::make('in_championship')
                    ->label(__('donation.labels.in_championship'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('championshipStage'),
                        false: fn (Builder $query) => $query->whereDoesntHave('championshipStage'),
                    ),
            ])
            ->headerActions([
            ])
            ->actions([
            ])
            ->bulkActions([
            ]);
    }
}
