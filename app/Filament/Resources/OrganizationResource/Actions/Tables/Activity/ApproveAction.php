<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Tables\Activity;

use App\Enums\UserRole;
use App\Models\Activity;
use Filament\Tables\Actions\Action as BaseAction;

class ApproveAction extends BaseAction
{
    public static function getDefaultName(): ?string
    {
        return 'approve';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->label(__('activity.actions.approve'));
        $this->icon('heroicon-o-check-circle');
        $this->action(fn (Activity $record) => $record->subject->approveChanges($record->id));
        $this->hidden(function (Activity $record) {
            return $record->causer?->role !== UserRole::ngo_admin || $record->isApproved();
        });
    }
}
