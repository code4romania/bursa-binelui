<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\UserResource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    public  function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    ->options(collect(
                        UserRole::options())->only([
                            UserRole::bb_admin->value,
                            UserRole::bb_manager->value,
                            UserRole::ngo_admin->value
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

            ]);
    }

}
