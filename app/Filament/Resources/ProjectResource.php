<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ProjectStatus;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\Widgets\ApprovedProject;
use App\Filament\Resources\ProjectResource\Widgets\NewProject;
use App\Filament\Resources\ProjectResource\Widgets\RejectedProject;
use App\Models\Project;
use App\Tables\Columns\ResourceNameColumn;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Position;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationGroup = 'Administrează';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')
                    ->label(__('project.labels.organization'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->relationship('organization', 'name')
                    ->required(),
                Forms\Components\Select::make('status')->options(ProjectStatus::options())->disabled()
                    ->label(__('project.labels.status'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Toggle::make('is_national')
                    ->label(__('project.labels.is_national'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('counties')
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
                Forms\Components\TextInput::make('category')
                    ->label(__('project.labels.category'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('target_budget')
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
                Forms\Components\TextInput::make('videos'),
                Forms\Components\TextInput::make('external_links'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('status')->options([
                    'heroicon-o-x-circle',
                    'heroicon-o-pencil' => ProjectStatus::draft->value,
                    'heroicon-o-clock' => ProjectStatus::disabled->value,
                    'heroicon-o-check-circle' => ProjectStatus::active->value,
                ]),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('category'),
                Tables\Columns\TextColumn::make('target_budget'),
                Tables\Columns\TextColumn::make('created_at')->date(),
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
            Filter::make('created_at')
                ->form([
                    Grid::make()->schema([
                        DatePicker::make('created_at')->label(__('project.filters.created_from'))->columnSpan(1),
                        DatePicker::make('created_at')->label(__('project.filters.created_until')),
                    ]),
                ])->columnSpan(2),
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
            ResourceNameColumn::make('project_info')
                ->label(__('project.labels.project')),
            Tables\Columns\TextColumn::make('category')
                ->label(__('project.labels.category')),
            Tables\Columns\TextColumn::make('target_budget')
                ->label(__('project.labels.target_budget')),
            Tables\Columns\TextColumn::make('created_at')->date('d-m-Y')
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
