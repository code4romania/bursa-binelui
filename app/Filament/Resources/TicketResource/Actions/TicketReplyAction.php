<?php

declare(strict_types=1);

namespace App\Filament\Resources\TicketResource\Actions;

use App\Filament\Resources\TicketResource\RelationManagers\MessagesRelationManager;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;

class TicketReplyAction extends CreateAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('ticket.action.reply'));
        $this->modalHeading(__('ticket.action.reply'));
        $this->visible(
            fn (MessagesRelationManager $livewire) => $livewire->ownerRecord->isOpen()
        );

        $this->modalButton(__('ticket.action.reply'));

        $this->disableCreateAnother();

        $this->using(function (array $data): Model {
            $data['user_id'] = auth()->user()->id;

            $relationship = $this->getRelationship();

            if (! $relationship) {
                return $this->getModel()::create($data);
            }

            if ($relationship instanceof BelongsToMany) {
                $pivotColumns = $relationship->getPivotColumns();

                return $relationship->create(
                    Arr::except($data, $pivotColumns),
                    Arr::only($data, $pivotColumns),
                );
            }

            return $relationship->create($data);
        });
    }
}
