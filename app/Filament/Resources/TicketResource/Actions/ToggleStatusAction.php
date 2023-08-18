<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Actions;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Filament\Pages\Actions\Action;

class ToggleStatusAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'toggle_status';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(
            fn (Ticket $record) => $record->isOpen()
                ? __('ticket.action.close')
                : __('ticket.action.reopen')
        );

        // $this->icon(
        //     fn (Ticket $record) => $record->isOpen()
        //         ? 'heroicon-s-check-circle'
        //         : null
        // );

        $this->color(
            fn (Ticket $record) => $record->isOpen()
                ? 'primary'
                : 'warning'
        );

        $this->modalHeading(
            fn (Ticket $record) => $record->isOpen()
                ? __('ticket.action_close_confirm.title')
                : __('ticket.action_reopen_confirm.title')
        );
        $this->modalSubheading(
            fn (Ticket $record) => $record->isOpen()
                ? __('ticket.action_close_confirm.text')
                : __('ticket.action_reopen_confirm.text')
        );
        $this->modalButton(
            fn (Ticket $record) => $record->isOpen()
                ? __('ticket.action_close_confirm.action')
                : __('ticket.action_reopen_confirm.action')
        );
        $this->modalWidth('md');
        $this->centerModal(false);

        $this->action(function (Ticket $record) {
            if ($record->isOpen()) {
                $record->close();
            } else {
                $record->open();
            }

            $this->success();
        });

        $this->successNotificationTitle(
            fn (Ticket $record) => $record->isOpen()
                ? __('ticket.action_reopen_confirm.success')
                : __('ticket.action_close_confirm.success')
        );

        $this->successRedirectUrl(
            fn (Ticket $record) => TicketResource::getUrl('view', $record)
        );
    }
}
