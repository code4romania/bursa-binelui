<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactMessageResource\Actions;

use App\Models\ContactMessage;
use Filament\Tables\Actions\Action;

class ToggleMarkAsReadAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'toggle_mark_as_read';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(fn (ContactMessage $record) => $record->mark_as_read
            ? __('contact_message.action.mark_unread')
            : __('contact_message.action.mark_read'));

        $this->icon(fn (ContactMessage $record) => $record->mark_as_read
            ? 'heroicon-o-x-circle'
            : 'heroicon-o-check-circle');

        $this->color(fn (ContactMessage $record) => $record->mark_as_read ? 'gray' : 'success');

        $this->action(function (ContactMessage $record) {
            $record->update(['mark_as_read' => ! $record->mark_as_read]);
        });
    }
}
