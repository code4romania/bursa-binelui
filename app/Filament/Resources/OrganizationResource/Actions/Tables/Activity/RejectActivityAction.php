<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Tables\Activity;

use App\Models\Activity;
use Filament\Tables\Actions\Action as BaseAction;

class RejectActivityAction extends BaseAction
{
    public static function getDefaultName(): ?string
    {
        return 'reject';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('activity.actions.reject'));

        $this->icon('heroicon-s-x');

        $this->color('danger');

        $this->action(fn (Activity $record) => $record->reject());

        $this->visible(fn (Activity $record) => $record->isPending());
    }
}
