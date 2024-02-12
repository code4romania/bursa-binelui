<?php

declare(strict_types=1);

namespace App\Filament\Resources\BadgeCategoryResource\Pages;

use App\Filament\Resources\BadgeCategoryResource;
use App\Models\BadgeCategory;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBadgeCategories extends ListRecords
{
    protected static string $resource = BadgeCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableHeading(): string
    {
        return __('badge.header.category_badge', ['number' => BadgeCategory::count()]);
    }
}
