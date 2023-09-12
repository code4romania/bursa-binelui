<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class VolunteersRelationManager extends RelationManager
{
    protected static string $relationship = 'volunteerRequest';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewForRecord(Model $record): bool
    {
        return $record->isDonor();
    }

    public static function getTitle(): string
    {
        return __('user.relations.volunteer');
    }

    protected function getTableHeading(): string
    {
        return __('user.relations.heading.volunteers', ['count' => $this->getTableQuery()->count()]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('volunteer.name')
                    ->required()
                    ->maxLength(255),
            ]);
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
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
