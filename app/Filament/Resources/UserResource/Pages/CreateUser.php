<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\UserResource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected static bool $canCreateAnother = false;

    public function form(Form $form): Form
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

            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
