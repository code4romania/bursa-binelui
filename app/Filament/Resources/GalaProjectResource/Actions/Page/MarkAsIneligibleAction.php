<?php

declare(strict_types=1);

namespace App\Filament\Resources\GalaProjectResource\Actions\Page;

use App\Models\GalaProject;
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

        $this->color('danger');

        $this->icon('heroicon-o-x-circle');

        $this->action(function (GalaProject $record) {
            $record->markAsIneligible();
        });

        $this->hidden(fn (GalaProject $record) => $record->eligible === false);
    }
}
