<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Filters\DateFilter;
use App\Filament\Forms\Components\Value;
use App\Filament\Resources\ContactMessageResource\Actions\ToggleMarkAsReadAction;
use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static function getNavigationGroup(): ?string
    {
        return __('navigation.group.manage');
    }

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationIcon = 'heroicon-o-mail';

    public static function getModelLabel(): string
    {
        return __('contact_message.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('contact_message.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Value::make('name')
                    ->label(__('contact_message.name'))
                    ->inlineLabel()
                    ->columnSpanFull(),

                Value::make('email')
                    ->label(__('contact_message.email'))
                    ->inlineLabel()
                    ->columnSpanFull(),

                Value::make('mark_as_read')
                    ->label(__('contact_message.mark_as_read'))
                    ->boolean(
                        trueLabel: new HtmlString('<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-success-50 text-success-700 ring-1 ring-inset ring-success-600/20">' . __('contact_message.read') . '</span>'),
                        falseLabel: new HtmlString('<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/20">' . __('contact_message.unread') . '</span>'),
                    )
                    ->inlineLabel()
                    ->columnSpanFull(),

                Value::make('created_at')
                    ->label(__('contact_message.created_at'))
                    ->withTime()
                    ->inlineLabel()
                    ->columnSpanFull(),

                Value::make('message')
                    ->label(__('contact_message.message'))
                    ->inlineLabel()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('contact_message.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label(__('contact_message.email'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('mark_as_read')
                    ->label(__('contact_message.mark_as_read'))
                    ->formatStateUsing(fn ($state) => $state ? __('contact_message.read') : __('contact_message.unread'))
                    ->sortable(),

                TextColumn::make('message')
                    ->label(__('contact_message.message'))
                    ->formatStateUsing(fn (string $state) => Str::limit($state, 50)),

                TextColumn::make('created_at')
                    ->label(__('contact_message.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                DateFilter::make('created_at')
                    ->label(__('contact_message.created_at')),
                TernaryFilter::make('mark_as_read')
                    ->label(__('contact_message.mark_as_read'))
                    ->queries(
                        true: fn (Builder $query) => $query->where('mark_as_read', true),
                        false: fn (Builder $query) => $query->where('mark_as_read', false),
                    ),
            ])
            ->actions([
                ToggleMarkAsReadAction::make()->iconButton(),
                ViewAction::make()->iconButton(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'view' => Pages\ViewContactMessage::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
