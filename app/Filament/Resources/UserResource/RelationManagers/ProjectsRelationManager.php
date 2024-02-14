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

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(): string
    {
        return __('user.relations.projects');
    }

    protected function getTableHeading(): string
    {
        return __('user.relations.heading.projects', ['count' => $this->getTableQuery()->count()]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name')
                    ->description(
                        fn ($record) => $record->organization->name
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord): bool
    {
        if ($ownerRecord->isDonor() || $ownerRecord->isSuperAdmin() || $ownerRecord->isSuperManager()) {
            return false;
        }

        return true;
    }
}
