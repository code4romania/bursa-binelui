<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\EuPlatescStatus;
use App\Filament\Filters\DateFilter;
use App\Filament\Resources\DonationResource\Actions\ExportAction;
use App\Filament\Resources\DonationResource\Pages;
use App\Forms\Components\Link;
use App\Models\Donation;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Str;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getPluralLabel(): ?string
    {
        return __('donation.label.plural');
    }

    public static function getModelLabel(): string
    {
        return __('donation.label.singular');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.manage');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Link::make('organizatii')->type('organization')
                    ->label(__('donation.labels.organization')),

                Link::make('project')->type('project')
                    ->label(__('donation.labels.project')),

                TextInput::make('full_name')
                    ->label(__('donation.labels.full_name'))
                    ->formatStateUsing(fn (Donation $record) => $record->full_name),

                TextInput::make('email')->email()
                    ->label(__('donation.labels.email')),

                TextInput::make('amount')
                    ->label(__('donation.labels.amount')),

                TextInput::make('created_at')
                    ->label(__('donation.labels.created_at')),

                TextInput::make('charge_date')
                    ->label(__('donation.labels.created_at')),

                TextInput::make('status')
                    ->label(__('donation.labels.status'))
                    ->formatStateUsing(fn (Donation $record) => __($record->status->label())),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->formatStateUsing(function (Donation $record) {
                        return sprintf('#%d', $record->id);
                    })
                    ->label(__('donation.labels.id'))
                    ->sortable(),
                TextColumn::make('organization.name')
                    ->label(__('donation.labels.organization'))
                    ->formatStateUsing(fn (Donation $record) => self::getOrganizationLink($record))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('project.name')
                    ->label(__('donation.labels.project'))
                    ->formatStateUsing(fn (Donation $record) => self::getProjectLink($record))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('full_name')
                    ->label(__('donation.labels.full_name')),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label(__('donation.labels.amount'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->formatStateUsing(fn (Donation $record) => $record->created_at->format('Y-m-d H:i'))
                    ->label(__('donation.labels.created_at'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status_updated_at')
                    ->formatStateUsing(fn (Donation $record) => $record->charge_date?->format('Y-m-d H:i'))
                    ->label(__('donation.labels.status_updated_at'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('donation.labels.status'))
                    ->formatStateUsing(fn (Donation $record) => __($record->status->label()))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('donation.labels.status'))
                    ->options(EuPlatescStatus::options())
                    ->multiple(),
                SelectFilter::make('organization_id')
                    ->label(__('donation.labels.organization'))
                    ->relationship('organization', 'name')
                    ->multiple(),
                SelectFilter::make('project_id')
                    ->label(__('donation.labels.project'))
                    ->relationship('project', 'name')
                    ->multiple(),
                TernaryFilter::make('has_user')
                    ->label(__('donation.labels.has_user'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('user_id'),
                        false: fn (Builder $query) => $query->whereNull('user_id'),
                    ),
                TernaryFilter::make('in_championship')
                    ->label(__('donation.labels.in_championship'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('championshipStage'),
                        false: fn (Builder $query) => $query->whereDoesntHave('championshipStage'),
                    ),
                DateFilter::make('created_at'),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                ExportAction::make('download')
            ])
            ->actions([
                ViewAction::make()->iconButton(),
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
            'index' => Pages\ListDonations::route('/'),
        ];
    }

    private static function getProjectLink(Donation $record): HtmlString
    {
        $url = route('filament.resources.projects.view', $record->project->id);
        $name = \Illuminate\Support\Str::words($record->project->name, 3, '...');

        return new HtmlString(sprintf('<a href="%s">%s</a>', $url, $name));
    }

    private static function getOrganizationLink(Donation $record)
    {
        $url = route('filament.resources.organizations.view', $record->organization->id);
        $name = Str::words($record->organization->name, 3, '...');

        return new HtmlString(sprintf('<a href="%s">%s</a>', $url, $name));
    }
}
