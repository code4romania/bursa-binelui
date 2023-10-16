<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ProjectStatus;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\Widgets\ApprovedProject;
use App\Filament\Resources\ProjectResource\Widgets\NewProject;
use App\Filament\Resources\ProjectResource\Widgets\RejectedProject;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Position;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationGroup = 'Administrează';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationBadge(): ?string
    {
        return (string) static::$model::whereIsPublished()->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Forms\Components\Toggle::make('is_national')
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
                Forms\Components\DatePicker::make('start')
                    ->required(),
                Forms\Components\DatePicker::make('end')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('scope')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('beneficiaries')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('reason_to_donate')
                    ->maxLength(65535),
                Forms\Components\Toggle::make('accepting_volunteers')
                    ->required(),
                Forms\Components\Toggle::make('accepting_comments')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('preview')
                    ->collection('preview')
                    ->label(__('project.labels.preview_image'))
                    ->mediaName('preview')
                    ->image()
                    ->maxFiles(1),
                SpatieMediaLibraryFileUpload::make('gallery')
                    ->collection('gallery')
                    ->label(__('project.labels.gallery'))
                    ->image()
                    ->multiple()
                    ->maxFiles(20),
                Forms\Components\Repeater::make('videos')->schema([
                    TextInput::make('url'),
                ]),
                Forms\Components\Repeater::make('external_links')->schema([
                    TextInput::make('url'),
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
            Filter::make('status_updated_at')
                ->form([
                    Grid::make()->schema([
                        DatePicker::make('status_updated_at')->label(__('project.filters.status_updated_at_from')),
                        DatePicker::make('status_updated_at')->label(__('project.filters.status_updated_at_until')),
                    ]),
                ]),
        ];
    }

    protected function getTableActionsPosition(): ?string
    {
        return Position::BeforeCells;
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
            'index' => Pages\ProjectIndex::route('/'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
            'view' => Pages\ViewProject::route('/{record}'),
        ];
    }

    public static function getWidgetColumns(): array
    {
        return [
            TextColumn::make('id')
                ->formatStateUsing(function (Project $record) {
                    return sprintf('#%d', $record->id);
                })
                ->label(__('project.labels.id'))
                ->sortable(),
            TextColumn::make('name')->description(fn (Project $record) => $record->organization->name)->searchable(),
            TextColumn::make('category')->formatStateUsing(fn (Project $record) => $record->categories->pluck('name')->join(', '))
                ->label(__('project.labels.category')),
            TextColumn::make('counties')->formatStateUsing(function (Project $record) {
                if ($record->is_national) {
                    return __('project.labels.national');
                }

                return $record->counties->pluck('name')->join(', ');
            })
                ->label(__('project.labels.counties')),
            TextColumn::make('target_budget')->formatStateUsing(function (Project $record) {
                return number_format($record->target_budget, 2, ',', '.');
            })
                ->label(__('project.labels.target_budget')),
            TextColumn::make('status_updated_at')->date('d-m-Y H:i:s')
                ->label(__('project.labels.status_updated_at')),
            TextColumn::make('created_at')->date('d-m-Y H:i:s')
                ->label(__('project.labels.created_at')),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            NewProject::class,
            ApprovedProject::class,
            RejectedProject::class,
        ];
    }
}
