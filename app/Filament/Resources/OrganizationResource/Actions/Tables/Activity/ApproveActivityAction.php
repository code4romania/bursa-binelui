<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Tables\Activity;

use App\Models\Activity;
use Filament\Tables\Actions\Action as BaseAction;

class ApproveActivityAction extends BaseAction
{
    public static function getDefaultName(): ?string
    {
        return 'approve';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('activity.actions.approve'));

        $this->icon('heroicon-s-check');

        $this->color('success');

        $this->action(fn (Activity $record) => $record->approve());

        $this->visible(fn (Activity $record) => $record->isPending());
    }
}
