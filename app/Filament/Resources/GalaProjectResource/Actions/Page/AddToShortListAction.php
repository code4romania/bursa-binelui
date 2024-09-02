<?php

declare(strict_types=1);

namespace App\Filament\Resources\GalaProjectResource\Actions\Page;

use App\Models\GalaProject;
use Filament\Pages\Actions\Action;

class AddToShortListAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'add-to-short-list';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('edition.actions.add-to-short-list'));

        $this->color('success');

        $this->icon('heroicon-s-plus-circle');

        $this->outlined();

        $this->action(function (GalaProject $record) {
            $record->addToShortList();
        });

        $this->hidden(fn (GalaProject $record) => $record->short_list === true);
    }
}
