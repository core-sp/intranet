<?php

namespace App\Observers;

use App\Ticket;

class TicketObserver
{
    public function created(Ticket $ticket)
    {
        $ticket->recordActivity('<strong>' . $ticket->owner->name . '</strong> definiu como <i>' . $ticket->priority . '</i> a prioridade deste chamado');

        $ticket->recordActivity('<strong>' . $ticket->owner->name . '</strong> criou o chamado <i>"' . $ticket->title . '"</i>');
    }

    public function updated(Ticket $ticket)
    {
        $key = array_key_last(request()->all());

        switch ($key) {
            case 'respondent_id':
                $user = \App\User::find(request()->all()[$key]);

                $user->name === auth()->user()->name ? $username = 'ele mesmo' : $username = $user->name;

                $ticket->recordActivity('<strong>' . auth()->user()->name . '</strong> atribuiu <i>' . $username . '</i> ao chamado');
            break;

            case 'profile_id':
                $ticket->recordActivity('<strong>' . auth()->user()->name . '</strong> atribuiu o chamado à área: <i>' . \App\Profile::find(request()->all()[$key])->name . '</i>');
            break;

            case 'status':
                $ticket->recordActivity('<strong>' . auth()->user()->name . '</strong> marcou o chamado como <i>' . $ticket->status . '</i>');
            break;

            default:
                $ticket->recordActivity('Alguém alterou algo');
            break;
        }
    }
}
