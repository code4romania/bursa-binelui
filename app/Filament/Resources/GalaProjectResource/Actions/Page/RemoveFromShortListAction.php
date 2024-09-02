<?php

declare(strict_types=1);

namespace App\Filament\Resources\GalaProjectResource\Actions\Page;

use App\Models\GalaProject;
use Filament\Pages\Actions\Action;

class RemoveFromShortListAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'remove-from-short-list';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('edition.actions.remove-from-short-list'));

        $this->color('danger');

        $this->icon('heroicon-s-minus-circle');

        $this->outlined();

        $this->action(function (GalaProject $record) {
            $record->removeFromShortList();
        });

        $this->hidden(fn (GalaProject $record) => $record->short_list === false);
    }
}
