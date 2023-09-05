<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Forms\Components\Value;
use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers\MessagesRelationManager;
use App\Filament\Resources\TicketResource\Widgets\ClosedTicketsWidget;
use App\Filament\Resources\TicketResource\Widgets\OpenTicketsWidget;
use App\Models\Ticket;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationGroup = 'Administrează';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationIcon = 'heroicon-o-mail';

    protected static ?string $recordTitleAttribute = 'subject';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Value::make('created_at')
                    ->label(__('ticket.date'))
                    ->withTime()
                    ->inlineLabel()
                    ->columnSpanFull(),

                Value::make('closed_at')
                    ->label(__('ticket.status'))
                    ->boolean(
                        trueLabel: new HtmlString('<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-success-50 text-success-700 ring-1 ring-inset ring-success-600/20">' . __('ticket.status.closed') . '</span>'),
                        falseLabel: new HtmlString('<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-warning-50 text-warning-700 ring-1 ring-inset ring-warning-600/20">' . __('ticket.status.open') . '</span>'),
                    )
                    ->inlineLabel()
                    ->columnSpanFull(),

                Value::make('user.name')
                    ->label(__('ticket.opened_by'))
                    ->inlineLabel()
                    ->columnSpanFull(),

                Value::make('organization.name')
                    ->label(__('ticket.organization'))
                    ->inlineLabel()
                    ->columnSpanFull(),

                Value::make('closed_at')
                    ->visible(fn (Ticket $record) => ! $record->isOpen())
                    ->label(__('ticket.closed_at'))
                    ->withTime()
                    ->inlineLabel()
                    ->columnSpanFull(),

                Value::make('subject')
                    ->label(__('ticket.subject'))
                    ->inlineLabel()
                    ->columnSpanFull(),

                Value::make('content')
                    ->label(__('ticket.message'))
                    ->inlineLabel()
                    ->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MessagesRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            OpenTicketsWidget::class,
            ClosedTicketsWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'view' => Pages\ViewTicket::route('/{record}'),
        ];
    }
}
