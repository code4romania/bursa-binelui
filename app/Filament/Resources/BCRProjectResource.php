<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BCRProjectResource\Pages;
use App\Models\BCRProject;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;

class BCRProjectResource extends Resource
{
    protected static ?string $model = BCRProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 7;

    public static function getPluralLabel(): ?string
    {
        return __('bcr-project.label.plural');
    }

    public static function getModelLabel(): string
    {
        return __('bcr-project.label.singular');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.manage');
    }

    protected static function getNavigationBadge(): ?string
    {
        return (string) BCRProject::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('bcr-project.labels.title'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->required(),

                Select::make('category_id')
                    ->label(__('bcr-project.labels.category'))
                    ->relationship('category', 'name')
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->required(),

                Select::make('county_id')
                    ->label(__('bcr-project.labels.county'))
                    ->relationship('county', 'name')
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->required(),

                Textarea::make('description')
                    ->label(__('bcr-project.labels.description'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->required(),

                DatePicker::make('start_date')
                    ->label(__('bcr-project.labels.start_date'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->required(),

                DatePicker::make('end_date')
                    ->label(__('bcr-project.labels.end_date'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->required(),

                TextInput::make('facebook_link')
                    ->label(__('bcr-project.labels.facebook_link'))
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('preview')
                    ->collection('preview')
                    ->label(__('project.labels.preview_image'))
                    ->mediaName('preview')
                    ->image()
                    ->maxFiles(1)
                    ->inlineLabel()
                    ->columnSpanFull(),

                SpatieMediaLibraryFileUpload::make('gallery')
                    ->collection('gallery')
                    ->label(__('project.labels.gallery'))
                    ->image()
                    ->multiple()
                    ->maxFiles(20)
                    ->inlineLabel()
                    ->columnSpanFull(),

                Repeater::make('external_links')
                    ->schema([
                        TextInput::make('title')
                            ->label(__('bcr-project.labels.external_links.title'))
                            ->inlineLabel()
                            ->columnSpanFull()
                            ->required(),
                        TextInput::make('link')->label(__('bcr-project.labels.external_links.link'))
                            ->inlineLabel()
                            ->columnSpanFull()
                            ->required(),
                    ])
                    ->label(__('bcr-project.labels.external_links.label'))
                    ->inlineLabel()
                    ->columnSpanFull(),

                Repeater::make('videos')
                    ->schema([
                        TextInput::make('link')->label(__('bcr-project.labels.videos'))
                            ->inlineLabel()
                            ->columnSpanFull()
                            ->required(),
                    ])
                    ->inlineLabel()
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->formatStateUsing(function (BcrProject $record) {
                        return sprintf('#%d', $record->id);
                    })
                    ->label(__('volunteer.column.id'))
                    ->sortable(),
                TextColumn::make('title')
                    ->label(__('bcr-project.labels.title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label(__('bcr-project.labels.start_date'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label(__('bcr-project.labels.end_date'))
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBCRProjects::route('/'),
            'create' => Pages\CreateBCRProject::route('/create'),
            'edit' => Pages\EditBCRProject::route('/{record}/edit'),
        ];
    }
}
