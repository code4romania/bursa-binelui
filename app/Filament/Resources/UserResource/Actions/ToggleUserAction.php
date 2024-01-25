<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Actions;

use App\Models\User;
use Filament\Tables\Actions\Action;

class ToggleUserAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return __('user.actions.toggle');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->color(fn(User $record) => $record->email_verified_at ? 'danger' : 'success');

        $this->icon(fn(User $record) => $record->email_verified_at ? 'heroicon-s-x' : 'heroicon-s-check');

        $this->requiresConfirmation();

        $this->modalHeading(function (User $record) {
                return __('user.toggle_modal.heading', [
                    'name' => $record->name,
                ]);
            });

        $this->modalSubheading(function  (User $record) {
            $status = (bool) $this->record?->email_verified_at;
            $key = sprintf('user.toggle_modal.subheading.%s', $status ? 'deactivate' : 'active');
            return __($key, ['name' => $record->name]);
        });

        $this->modalButton(function (User $record) {
            $status = (bool) $record->email_verified_at;
            $key = sprintf('user.toggle_modal.actions.%s', $status ? 'deactivate' : 'active');
            return __($key);
        });

        $this->action(function (User $record) {
            $record->toggleUser();
        });
    }
}
