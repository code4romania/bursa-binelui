<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;

class VolunteersRelationManager extends RelationManager
{
    protected static string $relationship = 'volunteerRequest';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(): string
    {
        return __('user.relations.volunteer');
    }

    protected function getTableHeading(): string
    {
        return __('user.relations.heading.volunteers', ['count' => $this->getTableQuery()->count()]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('model.name')
                    ->description(
                        fn ($record) => $record->targetingOrganization() ?
                        __('user.labels.volunteer_for_organization') :
                        __('user.labels.volunteer_for_project', [
                            'organization' => $record->model->organization->name,
                        ])
                    ),
                TextColumn::make('status')
                    ->formatStateUsing(
                        fn ($record) => $record->status->label()
                    )->color(fn ($record) => match ($record->status->value) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'primary',
                    }),
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
