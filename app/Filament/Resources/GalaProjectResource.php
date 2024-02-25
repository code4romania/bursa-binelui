<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalaProjectResource\Pages;
use App\Filament\Resources\GalaProjectResource\RelationManagers;
use App\Models\EditionCategories;
use App\Models\GalaProject;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class GalaProjectResource extends Resource
{
    protected static ?string $model = GalaProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 2;

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.gala');
    }

    public static function getModelLabel(): string
    {
        return __('edition.project.label.singular');
    }

    public static function getPluralLabel(): string
    {
        return __('edition.project.label.plural');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['gala']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('edition.project.label.plural'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('categories')
                    ->label(__('edition.labels.category'))
                    ->formatStateUsing(function ($state) {
                        $categories = json_decode($state);
                        return EditionCategories::query()
                            ->whereIn('id', $categories)
                            ->get()
                            ->map(fn ($category) => $category->name)
                            ->implode(', ');
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('youth')
                    ->label(__('edition.labels.youth'))
                    ->formatStateUsing(fn ($state) => $state ? __('field.boolean.true') : __('field.boolean.false'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('edition')
                    ->label(__('edition.label.singular'))
                    ->searchable()
                    ->formatStateUsing(fn ($state, $record) => $state->title)
                    ->sortable(),

                Tables\Columns\TextColumn::make('gala')
                    ->label(__('edition.labels.gala'))
                    ->formatStateUsing(fn ($state) => $state->title)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('edition.labels.status'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('eligible')
                    ->label(__('edition.labels.eligible'))
                    ->formatStateUsing(fn ($state) => !isset($state) ? '-' : ($state ? __('field.boolean.true') : __('field.boolean.false')))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('short_list')
                    ->label(__('edition.labels.short_list'))
                    ->formatStateUsing(fn ($state) => !isset($state) ? '-' : ($state ? __('field.boolean.true') : __('field.boolean.false')))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('edition')
                    ->label(__('edition.label.singular'))
                    ->relationship('edition', 'title')
                    ->multiple(),

                SelectFilter::make('galas')
                    ->label(__('edition.labels.gala'))
                    ->relationship('gala', 'title')
                    ->multiple(),

                Tables\Filters\TernaryFilter::make('eligible')
                    ->label(__('edition.labels.eligible')),

                Tables\Filters\TernaryFilter::make('youth')
                    ->label(__('edition.labels.youth')),


                Tables\Filters\TernaryFilter::make('short_list')
                    ->label(__('edition.labels.short_list')),

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                        Tables\Actions\ViewAction::make(),
                        Tables\Actions\EditAction::make(),
                        Tables\Actions\Action::make('download'),
                        Tables\Actions\DeleteAction::make(),
                    ]),
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
            'index' => Pages\ListGalaProjects::route('/'),
            'create' => Pages\CreateGalaProject::route('/create'),
            'edit' => Pages\EditGalaProject::route('/{record}/edit'),
        ];
    }
}
