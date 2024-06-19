<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\RelationManagers;

use App\Filament\Resources\VolunteerResource;
use App\Models\Project;
use App\Models\Volunteer;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class VolunteersRelationManager extends RelationManager
{
    protected static string $relationship = 'volunteers';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(): string
    {
        return __('volunteer.label.plural');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->formatStateUsing(function (Volunteer $record) {
                        return sprintf('#%d', $record->id);
                    })
                    ->label(__('volunteer.column.id'))
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('volunteer.column.name'))
                    ->searchable(),

                TextColumn::make('email')
                    ->label(__('volunteer.column.email'))
                    ->searchable(),

                TextColumn::make('project')
                    ->label(__('volunteer.column.project'))
                    ->formatStateUsing(fn ($record) => $record->model_type === Project::class ? VolunteerResource::getResourceLink($record->pivot, 'project') : 'General')
                    ->searchable(),

                IconColumn::make('status')
                    ->label(__('volunteer.column.status'))
                    ->options([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-check-circle' => 'approved',
                        'heroicon-o-x-circle' => 'rejected',
                    ])->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),

                TextColumn::make('has_user')
                    ->label(__('volunteer.column.has_user'))
                    ->formatStateUsing(fn ($record) => VolunteerResource::getResourceLink($record->pivot, 'user')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                //
            ]);
    }
}
