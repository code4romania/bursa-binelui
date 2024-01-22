<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\VolunteerStatus;
use App\Filament\Filters\DateFilter;
use App\Filament\Resources\VolunteerResource\Pages;
use App\Models\VolunteerRequest;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class VolunteerResource extends Resource
{
    protected static ?string $model = VolunteerRequest::class;

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getPluralLabel(): ?string
    {
        return __('volunteer.label.plural');
    }

    public static function getModelLabel(): string
    {
        return __('volunteer.label.singular');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.manage');
    }

    protected static function getNavigationBadge(): ?string
    {
        return (string) VolunteerRequest::where('status', VolunteerStatus::APPROVED)->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('volunteer.form.name'))
                    ->formatStateUsing(fn ($record) => $record->volunteer->name)
                    ->disabled(),
                TextInput::make('email')
                    ->label(__('volunteer.form.email'))
                    ->formatStateUsing(fn ($record) => $record->volunteer->email)
                    ->disabled(),
                TextInput::make('volunteer.phone')
                    ->label(__('volunteer.form.phone'))
                    ->formatStateUsing(fn ($record) => $record->volunteer->phone)
                    ->disabled(),
                Select::make('status')
                    ->label(__('volunteer.form.status'))
                    ->options(VolunteerStatus::options())
                    ->required(),
                Select::make('model_type')
                    ->label(__('volunteer.form.model_type'))
                    ->options([
                        'App\Models\Project' => 'Project',
                        'App\Models\Organization' => 'Organization',
                    ])
                    ->disabled(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->formatStateUsing(function (VolunteerRequest $record) {
                        return sprintf('#%d', $record->id);
                    })
                    ->label(__('volunteer.column.id'))
                    ->sortable(),
                TextColumn::make('volunteer.name')
                    ->label(__('volunteer.column.name'))
                    ->searchable(),
                TextColumn::make('volunteer.email')
                    ->label(__('volunteer.column.email'))
                    ->searchable(),
                TextColumn::make('project')
                    ->label(__('volunteer.column.project'))
                    ->formatStateUsing(fn ($record) => $record->model_type === 'App\Models\Project' ? self::getResourceLink($record, 'project') : 'General')
                    ->searchable(),
                TextColumn::make('organization_name')
                    ->label(__('volunteer.column.organization'))
                    ->formatStateUsing(fn ($record) => self::getResourceLink($record, 'organization'))
                    ->searchable(),
                IconColumn::make('status')
                    ->label(__('volunteer.column.status'))
                    ->options([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-check-circle' => 'approved',
                        'heroicon-o-x-circle' => 'rejected',
                    ])->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                TextColumn::make('has_user')
                    ->label(__('volunteer.column.has_user'))
                    ->formatStateUsing(fn ($record) => self::getResourceLink($record, 'user')),

            ])
            ->filters([
                SelectFilter::make('name')
                    ->multiple()
                    ->relationship('volunteer', 'name')
                    ->label(__('volunteer.filters.user')),
                TernaryFilter::make('has_user')
                    ->label(__('volunteer.filters.has_user'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas(
                            'volunteer',
                            fn (Builder $query) => $query->whereNotNull('user_id')
                        ),
                        false: fn (Builder $query) => $query->whereHas(
                            'volunteer',
                            fn (Builder $query) => $query->whereNull('user_id')
                        ),
                    ),
                DateFilter::make('created_at')

            ])
            ->actions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVolunteers::route('/'),
        ];
    }

    private static function getResourceLink(VolunteerRequest $record, string $type): HtmlString
    {
        return match ($type) {
            'project' => self::getProjectLink($record),
            'organization' => self::getOrganizationLink($record),
            'user' => self::getUserLink($record),
        };
    }

    private static function getProjectLink(VolunteerRequest $record): HtmlString
    {
        if ($record->model_type === 'App\Models\Project') {
            $url = route('filament.resources.projects.view', $record->model_id);
            $name = Str::words($record->model->name, 3, '...');

            return new HtmlString(sprintf('<a href="%s">%s</a>', $url, $name));
        }

        return new HtmlString('General');
    }

    private static function getOrganizationLink(VolunteerRequest $record): HtmlString
    {
        if ($record->model_type === 'App\Models\Organization') {
            $url = route('filament.resources.organizations.view', $record->model->id);
            $name = Str::words($record->model->name, 3, '...');

            return new HtmlString(sprintf('<a href="%s">%s</a>', $url, $name));
        }

        $url = route('filament.resources.organizations.view', $record->model->organization->id);
        $name = Str::words($record->model->organization->name, 3, '...');

        return new HtmlString(sprintf('<a href="%s">%s</a>', $url, $name));
    }

    private static function getUserLink(VolunteerRequest $record): HtmlString
    {
        if ($record->volunteer->user_id === null) {
            return new HtmlString('Nu');
        }
        $url = route('filament.resources.users.view', $record->volunteer->user_id);
        $name = Str::words($record->volunteer->name, 3, '...');

        return new HtmlString(sprintf('<a href="%s">%s</a>', $url, $name));
    }
}
