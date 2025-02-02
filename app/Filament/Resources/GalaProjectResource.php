<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\GalaProjectStatus;
use App\Enums\OrganizationType;
use App\Enums\ProjectArea;
use App\Filament\Forms\Components\Value;
use App\Filament\Resources\GalaProjectResource\Pages;
use App\Filament\Resources\GalaProjectResource\RelationManagers\PrizesRelationManager;
use App\Forms\Components\Link;
use App\Models\GalaProject;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->with(['gala']);
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Value::make('created_at')
                    ->label(__('edition.labels.created_at'))
                    ->inlineLabel()
                    ->withTime(),

                Link::make('organizatii')
                    ->type('organization')
                    ->label(__('organization.label.singular'))
                    ->inlineLabel()
                    ->columnSpanFull(),

                Select::make('gala')
                    ->label(__('edition.labels.gala'))
                    ->relationship(
                        'gala',
                        'title',
                    )
                    ->required()
                    ->inlineLabel(),

                TextInput::make('name')
                    ->label(__('edition.labels.project_title'))
                    ->required()
                    ->inlineLabel()
                    ->maxLength(200),

                Textarea::make('description')
                    ->label(__('edition.labels.project_description'))
                    ->required()
                    ->inlineLabel()
                    ->maxLength(700),

                Select::make('counties')
                    ->relationship('counties', 'name')
                    ->label(__('edition.labels.project_counties'))
                    ->columnSpanFull()
                    ->multiple()
                    ->required()
                    ->inlineLabel()
                    ->preload(),

                DatePicker::make('start_date')
                    ->label(__('edition.labels.start'))
                    ->placeholder(
                        fn ($state): string => today()
                            ->toFormattedDate()
                    )
                    ->inlineLabel(),

                DatePicker::make('end_date')
                    ->label(__('edition.labels.end'))
                    ->placeholder(
                        fn ($state): string => today()
                            ->toFormattedDate()
                    )
                    ->inlineLabel(),

                Select::make('categories')
                    ->relationship(
                        'categories',
                        'name',
                        function (Builder $query, GalaProject $record) {
                            return $query->where('edition_id', $record->gala->edition_id);
                        }
                    )
                    ->label(__('edition.labels.project_categories'))
                    ->preload()
                    ->multiple()
                    ->inlineLabel()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('regionalProjectFiles')
                    ->label(__('project.labels.gallery'))
                    ->collection('regionalProjectFiles')
                    ->inlineLabel()
                    ->disk(config('filesystems.default_public'))
                    ->image()
                    ->multiple()
                    ->maxFiles(20),

                Toggle::make('youth')
                    ->label(__('edition.labels.youth_project'))
                    ->inlineLabel()
                    ->required(),

                Select::make('organization_type')
                    ->label(__('edition.labels.organization_type'))
                    ->options(OrganizationType::options())
                    ->preload()
                    ->inlineLabel()
                    ->required(),

                Textarea::make('reason')
                    ->label(__('edition.labels.reason'))
                    ->required()
                    ->inlineLabel()
                    ->maxLength(1000),

                Textarea::make('solution')
                    ->label(__('edition.labels.solution'))
                    ->required()
                    ->inlineLabel()
                    ->maxLength(1000),

                Textarea::make('project_details')
                    ->label(__('edition.labels.project_details'))
                    ->required()
                    ->inlineLabel()
                    ->maxLength(1000),

                Textarea::make('special')
                    ->label(__('edition.labels.special'))
                    ->required()
                    ->inlineLabel()
                    ->maxLength(1000),

                Textarea::make('results')
                    ->label(__('edition.labels.results'))
                    ->required()
                    ->inlineLabel()
                    ->maxLength(1000),

                Textarea::make('proud')
                    ->label(__('edition.labels.proud'))
                    ->required()
                    ->inlineLabel()
                    ->maxLength(1000),

                Toggle::make('partnership')
                    ->inlineLabel()
                    ->required(),

                Textarea::make('partnership_details')
                    ->label(__('edition.labels.partnership_details'))
                    ->required()
                    ->inlineLabel()
                    ->maxLength(1000),

                Textarea::make('budget_details')
                    ->label(__('edition.labels.budget_details'))
                    ->required()
                    ->inlineLabel()
                    ->maxLength(1000),

                Select::make('area')
                    ->options(ProjectArea::options())
                    ->inlineLabel()
                    ->required(),

                Textarea::make('participants')
                    ->label(__('edition.labels.participants'))
                    ->required()
                    ->inlineLabel()
                    ->maxLength(1000),

                Textarea::make('team_details')
                    ->label(__('edition.labels.team_details'))
                    ->required()
                    ->inlineLabel()
                    ->maxLength(1000),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('edition.labels.id'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('edition.project.label.plural'))
                    ->searchable()
                    ->wrap()
                    ->sortable(),

                Tables\Columns\TextColumn::make('categories.name')
                    ->label(__('edition.labels.category'))
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('youth')
                    ->label(__('edition.labels.youth'))
                    ->formatStateUsing(fn ($state) => $state ? __('field.boolean.true') : __('field.boolean.false'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('gala.title')
                    ->label(__('edition.labels.gala'))
                    ->description(fn ($record) => $record->gala->edition->title)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('edition.labels.status'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('edition.labels.created_at'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('eligible')
                    ->label(__('edition.labels.eligible'))
                    ->formatStateUsing(fn ($state) => ! isset($state) ? '-' : ($state ? __('field.boolean.true') : __('field.boolean.false')))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('short_list')
                    ->label(__('edition.labels.short_list'))
                    ->formatStateUsing(fn ($state) => ! isset($state) ? '-' : ($state ? __('field.boolean.true') : __('field.boolean.false')))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('edition_id')
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
                //
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            PrizesRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', GalaProjectStatus::publish);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalaProjects::route('/'),
            'view' => Pages\ViewGalaProject::route('/{record}'),
        ];
    }
}
