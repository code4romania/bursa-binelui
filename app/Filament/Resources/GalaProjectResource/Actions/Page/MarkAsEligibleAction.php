<?php

declare(strict_types=1);

namespace App\Filament\Resources\GalaProjectResource\Actions\Page;

use Filament\Pages\Actions\Action;

class MarkAsEligibleAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'mark-as-eligible';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('edition.actions.mark-as-eligible'));

        $this->action(function () {
            $this->getRecord()->markAsEligible();
        });
    }
}
