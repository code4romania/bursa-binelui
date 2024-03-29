<?php

declare(strict_types=1);

namespace App\Filament\Resources\BadgeResource\RelationManagers;

use App\Enums\BadgeCategories;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(): string
    {
        return __('donation.labels.donors');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->description(fn ($record) => $record->email),

                TextColumn::make('allocated_at')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label(__('badge.action.attach'))
                    ->modalHeading(__('badge.action.attach'))
                    ->color('primary'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->label(__('badge.action.detach')),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord): bool
    {
        return $ownerRecord->badgeCategory->title === BadgeCategories::DONATIONS->value;
    }
}
