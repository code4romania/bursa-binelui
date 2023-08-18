<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Ticket $ticket): bool
    {
        return $user->isBbAdmin() || $user->organization->is($ticket->organization);
    }

    public function create(User $user): bool
    {
        return $user->isNgoAdmin();
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->isBbAdmin() || ($user->isNgoAdmin() && $user->organization->is($ticket->organization));
    }

    public function reply(User $user, Ticket $ticket): bool
    {
        return $this->update($user, $ticket) && $ticket->isOpen();
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return false;
    }

    public function restore(User $user, Ticket $ticket): bool
    {
        return false;
    }

    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return false;
    }
}
