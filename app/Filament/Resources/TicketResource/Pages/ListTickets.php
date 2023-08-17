<?php

declare(strict_types=1);

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Filament\Resources\TicketResource\Widgets\ClosedTicketsWidget;
use App\Filament\Resources\TicketResource\Widgets\OpenTicketsWidget;
use Filament\Resources\Pages\Page;

class ListTickets extends Page
{
    protected static string $resource = TicketResource::class;

    protected static string $view = 'filament.resources.page';

    protected static ?string $title = '';

    protected function getHeaderWidgets(): array
    {
        return [
            OpenTicketsWidget::class,
            ClosedTicketsWidget::class,
        ];
    }

    protected function getHeaderWidgetsColumns(): int
    {
        return 1;
    }
}
