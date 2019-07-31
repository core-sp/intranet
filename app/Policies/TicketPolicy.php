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
        return $user->is($ticket->owner) || $user->hasSameTicketProfile($ticket);
    }

    public function interact(User $user, Ticket $ticket)
    {
        return $user->is($ticket->owner) || $user->is($ticket->respondent);
    }

    public function close(User $user, Ticket $ticket)
    {
        return $user->is($ticket->owner);
    }

    public function finish(User $user, Ticket $ticket)
    {
        return $user->is($ticket->respondent);
    }

    public function assign(User $user, Ticket $ticket)
    {
        return $user->hasSameTicketProfile($ticket);
    }
}
