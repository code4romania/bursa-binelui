<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ProjectCategory;
use App\Enums\ProjectStatus;
use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Position;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Query\Builder;

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
                    ->relationship('organization', 'name')
                    ->required(),
                Forms\Components\Select::make('status')->options(ProjectStatus::options())->disabled()
                    ->required(),
                Forms\Components\Toggle::make('is_national')
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('county_id')
                    ->relationship('counties', 'name')
                    ->multiple()
                    ->required()
                    ->preload()
                    ->hidden(function (callable $get) {
                        return $get('is_national') === true;
                    }),
                Forms\Components\TextInput::make('category')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
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
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(ProjectStatus::options())
                    ->label(__('project.filters.status')),
                SelectFilter::make('organization')
                    ->multiple()
                    ->relationship('organization', 'name')
                    ->label(__('project.filters.organization')),
                SelectFilter::make('category')
                    ->multiple()
                    ->options(ProjectCategory::options())
                    ->label(__('project.filters.category')),
                SelectFilter::make('counties')
                    ->multiple()
                    ->relationship('counties', 'name')
                    ->label(__('project.filters.counties')),
                Filter::make('created_at')
                    ->form([
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\DatePicker::make('created_at')->label(__('project.filters.created_from'))->columnSpan(1),
                            Forms\Components\DatePicker::make('created_at')->label(__('project.filters.created_until')),
                        ]),
                    ])->columnSpan(2),
                //                    ->query(function (Builder $query, array $data): Builder {
                //                        return $query
                //                            ->when(
                //                                $data['created_at'],
                //                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                //                            )
                //                            ->when(
                //                                $data['created_at'],
                //                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                //                            );
                //                    })
            ])
            ->filtersLayout(Layout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make(__('project.actions.approve'))
                    ->action(function () {
                    })
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation(),
                Tables\Actions\Action::make(__('project.actions.reject'))
                    ->action(function () {
                    })
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListProjects::route('/'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
