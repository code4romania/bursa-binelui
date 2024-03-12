<?php

declare(strict_types=1);

namespace App\Filament\Resources\GalaProjectResource\Actions\Page;

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

        $this->action(function () {
            $this->getRecord()->addToShortList();
        });
    }
}
