<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Forms\Components\Field;
use Illuminate\Support\Collection;

class UserLink extends Field
{
    protected string $view = 'forms.components.user-link';

    public function getUsers(): Collection
    {
        return $this->getRecord()
            ->users
            ->map(fn (User $user) => [
                'name' => $user->name,
                'url' => UserResource::getUrl('view', $user),
            ]);
    }
}
