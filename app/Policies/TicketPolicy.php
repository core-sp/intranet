<?php

namespace App\Policies;

use App\User;
use App\Ticket;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;
    
    public function view(User $user, Ticket $ticket)
    {
        return $user->is($ticket->owner) || (auth()->user()->profile->id === $ticket->profile->id);
    }

    public function interact(User $user, Ticket $ticket)
    {
        return $user->is($ticket->owner) || $user->profile->id === $ticket->profile->id;
    }
}
