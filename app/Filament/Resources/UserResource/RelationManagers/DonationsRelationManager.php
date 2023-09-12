<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\RelationManagers;

use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class DonationsRelationManager extends RelationManager
{
    protected static string $relationship = 'donations';

    protected static ?string $recordTitleAttribute = 'uuid';

    public static function getTitle(): string
    {
        return __('user.relations.donations');
    }

    protected function getTableHeading(): string | Htmlable | Closure | null
    {
        return __('user.relations.heading.donations', ['count' => $this->getTableQuery()->count(), 'total' => $this->getTableQuery()->sum('amount')]);
    }

    public static function canViewForRecord(Model $record): bool
    {
        return $record->isDonor();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project.name')
                    ->label(__('donation.labels.project'))
                    ->relationship('project', 'name')
                    ->inlineLabel()
                    ->required(),

                Select::make('organization.name')
                    ->label(__('donation.labels.organization'))
                    ->relationship('organization', 'name')
                    ->inlineLabel()
                    ->required(),

                TextInput::make('status')
                    ->label(__('donation.labels.status'))
                    ->inlineLabel()
                    ->required(),

                TextInput::make('amount')
                    ->label(__('donation.labels.amount'))
                    ->inlineLabel()
                    ->required(),

                TextInput::make('approved_at')
                    ->label(__('donation.labels.approved_at'))
                    ->inlineLabel()
                    ->required(),

                TextInput::make('charged_date')
                    ->label(__('donation.labels.charged_date'))
                    ->inlineLabel()
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name')
                    ->label(__('donation.labels.project')),

                TextColumn::make('organization.name')
                    ->label(__('donation.labels.organization')),

                TextColumn::make('amount')
                    ->label(__('donation.labels.amount')),

                TextColumn::make('created_at')
                    ->label(__('donation.labels.created_at')),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }
}
