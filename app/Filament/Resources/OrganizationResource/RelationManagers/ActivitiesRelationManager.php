<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\RelationManagers;

use App\Filament\Resources\OrganizationResource\Actions\Tables\Activity\ApproveActivityAction;
use App\Filament\Resources\OrganizationResource\Actions\Tables\Activity\RejectActivityAction;
use App\Filament\Resources\OrganizationResource\Actions\Tables\Activity\ViewActivityAction;
use App\Filament\Resources\UserResource;
use App\Models\Activity;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    // protected static ?string $recordTitleAttribute = 'description';

    public static function getTitle(): string
    {
        return __('activity.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('activity.column.created_at'))
                    ->sortable(),

                TextColumn::make('changed_field')
                    ->label(__('activity.column.changed_field'))
                    ->formatStateUsing(
                        fn ($state) => __('organization.labels.' . $state)
                    ),

                TextColumn::make('causer.name')
                    ->label(__('activity.column.causer'))
                    ->description(
                        fn (Activity $record) => $record->causer?->role->label()
                    )
                    ->url(
                        fn (Activity $record) => $record->causer
                            ? UserResource::getUrl('view', $record->causer)
                            : null
                    )
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('activity.column.status')),
            ])
            ->filters([
                Filter::make('created_at')
                    ->columns()
                    ->form([
                        DatePicker::make('logged_from')
                            ->label(__('activity.filter.logged_from'))
                            ->placeholder(
                                fn ($state): string => today()
                                    ->setDay(17)
                                    ->setMonth(11)
                                    ->subYear()
                                    ->toFormattedDate()
                            ),

                        DatePicker::make('logged_until')
                            ->label(__('activity.filter.logged_until'))
                            ->placeholder(
                                fn ($state): string => today()
                                    ->toFormattedDate()
                            ),
                    ])
                    ->query(
                        fn (Builder $query, array $data) => $query->betweenDates(
                            data_get($data, 'logged_from'),
                            data_get($data, 'logged_until'),
                        )
                    )
                    ->indicateUsing(
                        fn (array $data) => collect(['logged_from', 'logged_until'])
                            ->mapWithKeys(function (string $filter) use ($data) {
                                $value = data_get($data, $filter);

                                if (! \is_null($value)) {
                                    $value = __("activity.indicator.{$filter}", [
                                        'date' => Carbon::parse($value)->toFormattedDate(),
                                    ]);
                                }

                                return [$filter => $value];
                            })
                            ->filter()
                            ->all()
                    ),

                // SelectFilter::make('causer_id')
                //     ->relationship('causer', 'name'),

                // SelectFilter::make('changed_field'),
            ])
            ->filtersLayout(Layout::AboveContent)
            ->actions([
                ViewActivityAction::make(),

                ApproveActivityAction::make(),

                RejectActivityAction::make(),
            ]);
    }
}
