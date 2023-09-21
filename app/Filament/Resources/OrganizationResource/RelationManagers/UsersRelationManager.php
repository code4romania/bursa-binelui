<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\RelationManagers;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(): string
    {
        return __('user.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('user.name'))
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label(__('user.email'))
                    ->email()
                    ->unique('users', 'email')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('user.name'))
                    ->sortable(),

                TextColumn::make('email')
                    ->label(__('user.email'))
                    ->sortable(),

                TextColumn::make('role')
                    ->label(__('user.role'))
                    ->getStateUsing(fn (User $record) => $record->role?->label())
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label(__('user.action.attach'))
                    ->modalHeading(__('user.action.attach'))
                    ->color('primary'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->label(__('user.action.detach')),
            ])
            ->bulkActions([
                //
            ]);
    }
}
