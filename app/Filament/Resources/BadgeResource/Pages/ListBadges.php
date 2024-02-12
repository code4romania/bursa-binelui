<?php

declare(strict_types=1);

namespace App\Filament\Resources\BadgeResource\Pages;

use App\Filament\Resources\BadgeResource;
use App\Models\Badge;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBadges extends ListRecords
{
    protected static string $resource = BadgeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->with('media');
    }

    protected function getTableHeading(): string
    {
        return __('badge.header.badge', ['number' => Badge::count()]);
    }
}
