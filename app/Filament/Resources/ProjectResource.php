<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ProjectStatus;
use App\Filament\Filters\DateFilter;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers\ActivitiesRelationManager;
use App\Filament\Resources\ProjectResource\RelationManagers\DonationsRelationManager;
use App\Filament\Resources\ProjectResource\RelationManagers\VolunteersRelationManager;
use App\Filament\Resources\ProjectResource\Widgets\ApprovedProject;
use App\Filament\Resources\ProjectResource\Widgets\NewProject;
use App\Filament\Resources\ProjectResource\Widgets\PendingChangesProjectWidget;
use App\Filament\Resources\ProjectResource\Widgets\RejectedProject;
use App\Forms\Components\Link;
use App\Models\Project;
use Filament\Forms;
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
use Filament\Tables\Actions\Position;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationGroup = 'Administrează';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationBadge(): ?string
    {
        return (string) static::$model::count();
    }

    public static function getModelLabel(): string
    {
        return __('project.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('project.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Link::make('organizatii')
                    ->type('organization')
                    ->label(__('organization.labels.administrator'))
                    ->inlineLabel()
                    ->columnSpanFull(),
                Select::make('organization_id')
                    ->label(__('project.labels.organization'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->relationship('organization', 'name')
                    ->disabled()
                    ->required(),
                Select::make('status')->options(ProjectStatus::options())->disabled()
                    ->label(__('project.labels.status'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('visible_status')
                    ->label(__('project.labels.visible_status'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->formatStateUsing(function (Project $record) {
                        return __(sprintf('project.visible_status.%s', $record->visible_status));
                    })
                    ->hidden(
                        function (callable $get) {
                            return $get('status') != ProjectStatus::approved;
                        }
                    )
                    ->disabled(),
                Toggle::make('is_national')
                    ->label(__('project.labels.is_national'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->reactive()
                    ->required(),
                Select::make('counties')
                    ->relationship('counties', 'name')
                    ->label(__('project.labels.counties'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->multiple()
                    ->required()
                    ->preload()
                    ->hidden(function (callable $get) {
                        return $get('is_national') === true;
                    }),
                Select::make('categories')
                    ->relationship('categories', 'name')
                    ->label(__('project.labels.category'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->multiple()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('target_budget')
                    ->required(),
                DatePicker::make('start')
                    ->required(),
                DatePicker::make('end')
                    ->required(),
                Textarea::make('description')
                    ->maxLength(1000),
                Textarea::make('scope')
                    ->maxLength(860),
                Textarea::make('beneficiaries')
                    ->maxLength(1000),
                Textarea::make('reason_to_donate')
                    ->maxLength(65535),
                Toggle::make('accepting_volunteers')
                    ->required(),
                Toggle::make('accepting_comments')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('preview')
                    ->label(__('project.labels.preview_image'))
                    ->collection('preview')
                    ->mediaName('preview')
                    ->disk(config('filesystems.default_public'))
                    ->image()
                    ->maxFiles(1),
                SpatieMediaLibraryFileUpload::make('gallery')
                    ->label(__('project.labels.gallery'))
                    ->collection('gallery')
                    ->disk(config('filesystems.default_public'))
                    ->image()
                    ->multiple()
                    ->maxFiles(20),
                Forms\Components\Repeater::make('videos')
                    ->schema([
                        TextInput::make('url')
                            ->url()
                            ->required(),
                    ]),
                Forms\Components\Repeater::make('external_links')->schema([
                    TextInput::make('title')
                        ->required(),

                    TextInput::make('url')
                        ->url()
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('status')->options([
                    'heroicon-o-x-circle',
                    'heroicon-o-pencil' => ProjectStatus::draft->value,
                    'heroicon-o-clock' => ProjectStatus::rejected->value,
                    'heroicon-o-check-circle' => ProjectStatus::approved->value,
                ]),
                TextColumn::make('name'),
                TextColumn::make('category'),

                TextColumn::make('created_at')->date(),
            ]);
    }

    public static function getWidgetFilters(): array
    {
        return [
            SelectFilter::make('organization')
                ->multiple()
                ->relationship('organization', 'name')
                ->label(__('project.filters.organization')),
            SelectFilter::make('category')
                ->multiple()
                ->relationship('categories', 'name')
                ->label(__('project.filters.category')),
            SelectFilter::make('counties')
                ->multiple()
                ->relationship('counties', 'name')
                ->label(__('project.filters.counties')),
            DateFilter::make('created_at')
                ->label(__('project.filters.created_between')),
        ];
    }

    protected function getTableActionsPosition(): ?string
    {
        return Position::BeforeCells;
    }

    public static function getRelations(): array
    {
        return [
            VolunteersRelationManager::class,
            DonationsRelationManager::class,
            ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ProjectIndex::route('/'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
            'view' => Pages\ViewProject::route('/{record}'),
        ];
    }

    public static function getWidgetColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label(__('project.labels.id'))
                ->formatStateUsing(function (Project $record) {
                    return sprintf('#%d', $record->id);
                })
                ->sortable(),

            TextColumn::make('name')
                ->label(__('project.labels.name'))
                ->description(fn (Project $record) => $record->organization->name)
                ->searchable(),

            TextColumn::make('category')
                ->label(__('project.labels.category'))
                ->formatStateUsing(fn (Project $record) => $record->categories->pluck('name')->join(', ')),

            TextColumn::make('counties')
                ->label(__('project.labels.counties'))
                ->formatStateUsing(
                    fn (Project $record) => $record->is_national ?
                        __('project.labels.national') :
                        $record->counties->pluck('name')->join(', ')
                ),

            TextColumn::make('target_budget')
                ->label(__('project.labels.target_budget'))
                ->formatStateUsing(
                    fn (Project $record) => number_format($record->target_budget, 2, ',', '.')
                ),

            TextColumn::make('status_updated_at')
                ->label(__('project.labels.status_updated_at'))
                ->date('d-m-Y H:i:s'),

            TextColumn::make('created_at')
                ->label(__('project.labels.created_at'))
                ->date('d-m-Y H:i:s'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            NewProject::class,
            PendingChangesProjectWidget::class,
            ApprovedProject::class,
            RejectedProject::class,
        ];
    }
}
