<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Resources\Pages\ListRecords;

class ListContactMessages extends ListRecords
{
    protected static string $resource = ContactMessageResource::class;

    protected function getActions(): array
    {
        return [];
    }

    protected function getTableHeading(): string
    {
        return __('contact_message.header', ['number' => ContactMessage::count()]);
    }
}
