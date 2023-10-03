<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\UserRole;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\BadgesRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\DonationsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\VolunteersRelationManager;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getPluralLabel(): ?string
    {
        return __('user.label.plural');
    }

    public static function getModelLabel(): string
    {
        return __('user.label.singular');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.manage');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                TextInput::make('name')
                    ->label(__('user.name'))
                    ->inlineLabel()
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label(__('user.email'))
                    ->email()
                    ->unique('users', 'email', ignoreRecord: true)
                    ->inlineLabel()
                    ->required(),

                Select::make('role')
                    ->label(__('user.role'))
                    ->options(UserRole::options())
                    ->enum(UserRole::class)
                    ->reactive()
                    ->inlineLabel()
                    ->required(),

                Select::make('organization')
                    ->label(__('user.organization'))
                    ->relationship('organization', 'name')
                    ->hidden(fn (callable $get) => UserRole::ADMIN->is($get('role')))
                    ->searchable()
                    ->inlineLabel()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('user.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('user.email'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label(__('user.role'))
                    ->getStateUsing(fn ($record) => $record->role->label())
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label(__('user.filters.type'))
                    ->placeholder(__('user.filters.placeholder'))
                    ->options(UserRole::options())
                    ->multiple(),
                SelectFilter::make('organization')
                    ->label(__('user.organization'))
                    ->relationship('organization', 'name')
                    ->searchable(),
                TernaryFilter::make('has_donations')
                    ->label(__('user.filters.has_donations'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('donations'),
                        false: fn (Builder $query) => $query->doesntHave('donations'),
                    ),
                TernaryFilter::make('is_volunteer')
                    ->label(__('user.filters.is_volunteer'))
                    ->queries(
                        true: fn (Builder $query) => $query->has('volunteer'),
                        false: fn (Builder $query) => $query->doesntHave('volunteer'),
                    ),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DonationsRelationManager::class,
            VolunteersRelationManager::class,
            BadgesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
