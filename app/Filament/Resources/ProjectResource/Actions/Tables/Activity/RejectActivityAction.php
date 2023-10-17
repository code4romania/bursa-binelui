<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Actions\Tables\Activity;

use App\Models\Activity;
use Filament\Forms\Components\Textarea;
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

        $this->requiresConfirmation();

        $this->modalHeading(__('activity.reject_modal.heading'));

        $this->modalSubheading(
            fn (Activity $record) => __('activity.reject_modal.subheading', [
                'name' => __('project.labels.' . $record->changed_field),
                'resource' => $record->subject->name,
            ])
        );

        $this->form([
            Textarea::make('reason')
                ->label(__('activity.reject_modal.reason'))
                ->default(function (Activity $record) {
                    return $record->subject->name;
                })
                ->required(),
        ]);

        $this->modalButton(__('activity.actions.reject'));

        $this->action(function (Activity $record, array $data) {
            $reason = strip_tags($data['reason']);

            $record->reject($reason);
        });

        $this->visible(fn (Activity $record) => $record->isPending());
    }
}
