<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BadgeCategoryResource\Pages;
use App\Models\BadgeCategory;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;

class BadgeCategoryResource extends Resource
{
    protected static ?string $model = BadgeCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 6;

    public static function getPluralLabel(): ?string
    {
        return __('badge.category.labels.plural');
    }

    public static function getModelLabel(): string
    {
        return __('badge.category.labels.singular');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.manage');
    }

    protected static function getNavigationBadge(): ?string
    {
        return (string) BadgeCategory::query()->whereHas('badges')->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('badge.category.title'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('badge.category.title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('badges_count')
                    ->counts('badges')
                    ->label(__('badge.category.badges_count'))
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('has_badges')
                    ->label(__('badge.filters.has_badges'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('badges'),
                        false: fn (Builder $query) => $query->whereDoesntHave('badges')
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBadgeCategories::route('/'),
        ];
    }
}
