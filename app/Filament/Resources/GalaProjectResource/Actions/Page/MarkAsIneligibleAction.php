<?php

declare(strict_types=1);

namespace App\Filament\Resources\GalaProjectResource\Actions\Page;

use Filament\Pages\Actions\Action;

class MarkAsIneligibleAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'mark-as-ineligible';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('edition.actions.mark-as-ineligible'));

        $this->action(function () {
            $this->getRecord()->markAsIneligible();
        });
    }
}
