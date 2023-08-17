<?php

declare(strict_types=1);

namespace App\Filament\Resources\TicketResource\RelationManagers;

use App\Filament\Resources\TicketResource\Actions\TicketReplyAction;
use App\Models\TicketMessage;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Textarea::make('content')
                    ->label(__('ticket.message'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    Split::make([
                        TextColumn::make('user.name')
                            ->translateLabel()
                            ->weight('bold')
                            ->color(function (Component $livewire, TicketMessage $record) {
                                if ($record->user->isBbAdmin()) {
                                    return 'warning';
                                }

                                return 'secondary';
                            })
                            ->grow(false),

                        TextColumn::make('created_at')
                            ->translateLabel()
                            ->dateTime()
                            ->color('secondary')
                            ->size('sm'),
                    ]),
                    TextColumn::make('content')
                        ->formatStateUsing(fn ($state) => new HtmlString(nl2br($state)))
                        ->wrap(),
                ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                TicketReplyAction::make(),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('created_at', 'desc');
    }
}
