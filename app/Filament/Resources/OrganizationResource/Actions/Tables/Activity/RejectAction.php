<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Tables\Activity;

use App\Enums\UserRole;
use App\Models\Activity;
use Filament\Tables\Actions\Action as BaseAction;

class RejectAction extends BaseAction
{
    public static function getDefaultName(): ?string
    {
        return 'reject';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->label(__('activity.actions.reject'));
        $this->icon('heroicon-o-x-circle');
        $this->color('danger');
        $this->action(fn (Activity $record) => $record->subject->rejectChanges($record->id));
        $this->hidden(function (Activity $record) {
            return $record->causer?->role !== UserRole::ngo_admin || $record->isRejected();
        });
    }
}
