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

class OrganizationRelationManager extends RelationManager
{
    protected static string $relationship = 'organizations';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(): string
    {
        return __('organization.label.plural');
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
                    ->sortable()
                    ->searchable(),

                TextColumn::make('allocated_at')
                    ->sortable()
                    ->searchable(),

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
        return $ownerRecord->badgeCategory->title === BadgeCategories::PROJECTS_ONG->value;
    }
}
