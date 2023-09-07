<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\UserRole;
use App\Filament\Resources\UserResource\Pages;
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
use PHPUnit\Util\Filter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getPluralLabel() : ?string{
        return __('user.label.plural');
    }


    public static function getModelLabel() : string{
        return __('user.label.singular');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.manage');
    }

    public static function form(Form $form): Form
    {
        return $form ->schema([
            TextInput::make('name')
                ->label(__('user.name'))
                ->required(),
            TextInput::make('email')
                ->label(__('user.email'))
                ->email()
                ->unique('users', 'email')
                ->required(),
            Select::make('role')
                ->label(__('user.role'))
                ->options(
                    collect(
                        UserRole::options()
                    )->only(
                        [
                            UserRole::bb_admin->value,
                            UserRole::bb_manager->value,
                            UserRole::ngo_admin->value,
                        ]
                    )->toArray()
                )->reactive()
                ->required(),
            Select::make('organization')
                ->label(__('user.organization'))
                ->relationship('organization', 'name')
                ->hidden(function (callable $get) {
                    return $get('role') !== UserRole::ngo_admin->value;
                })
                ->searchable()
                ->preload()
                ->required(),

        ]);;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('role')->searchable()->sortable(),
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
                        true: fn (Builder $query) => $query,
                        false: fn (Builder $query) => $query,
                    ),
                TernaryFilter::make('is_volunteer')
                    ->label(__('user.filters.is_volunteer'))
                    ->queries(
                        true: fn (Builder $query) => $query,
                        false: fn (Builder $query) => $query,
                    ),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
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
