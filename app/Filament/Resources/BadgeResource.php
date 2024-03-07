<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\BadgeType;
use App\Filament\Resources\BadgeResource\Pages;
use App\Filament\Resources\BadgeResource\RelationManagers\OrganizationRelationManager;
use App\Filament\Resources\BadgeResource\RelationManagers\UsersRelationManager;
use App\Models\Badge;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;

class BadgeResource extends Resource
{
    protected static ?string $model = Badge::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-badge-check';

    public static function getPluralLabel(): ?string
    {
        return __('badge.labels.plural');
    }

    public static function getModelLabel(): string
    {
        return __('badge.labels.singular');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.manage');
    }

    protected static function getNavigationBadge(): ?string
    {
        return (string) Badge::query()->whereHas('users')->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('badge.title'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->maxLength(200)
                    ->required(),

                Select::make('badge_category_id')
                    ->label(__('badge.category.title'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->relationship('badgeCategory', 'title')
                    ->required(),

                Select::make('type')
                    ->label(__('badge.type'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->options(BadgeType::options())
                    ->default(BadgeType::MANUAL)
                    ->disabled()
                    ->required(),

                Textarea::make('description')
                    ->label(__('badge.description'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('image')
                    ->label(__('badge.image'))
                    ->inlineLabel()
                    ->disk(config('filesystems.default_public'))
                    ->required()
                    ->maxFiles(1)
                    ->image()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label(__('badge.image'))
                    ->square(),

                TextColumn::make('title')
                    ->label(__('badge.title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->formatStateUsing(fn (Badge $record) => $record->type->label())
                    ->label(__('badge.type'))
                    ->sortable(),

                TextColumn::make('users_count')
                    ->label(__('badge.users_count'))
                    ->counts('users')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('badge_category_id')
                    ->label(__('badge.filters.category'))
                    ->relationship('badgeCategory', 'title')
                    ->multiple(),
                TernaryFilter::make('has_users')
                    ->label(__('badge.filters.has_users'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('users'),
                        false: fn (Builder $query) => $query->whereDoesntHave('users')
                    ),
            ])
            ->actions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UsersRelationManager::class,
            OrganizationRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBadges::route('/'),
            'create' => Pages\CreateBadge::route('/create'),
            'view' => Pages\ViewBadge::route('/{record}'),
            'edit' => Pages\EditBadge::route('/{record}/edit'),
        ];
    }
}
