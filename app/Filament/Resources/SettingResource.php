<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.content');
    }

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function getModelLabel(): string
    {
        return __('setting.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('setting.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('slug')
                    ->label(__('setting.slug'))
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),

                TextInput::make('value')
                    ->label(__('setting.value'))
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->label(__('setting.slug'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('value')
                    ->label(__('setting.value'))
                    ->limit(60)
                    ->searchable(),
            ])
            ->defaultSort('slug')
            ->actions([
                EditAction::make()->iconButton(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
