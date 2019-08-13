<?php

namespace App\Observers;

use App\Interaction;

class InteractionObserver
{
    public function created(Interaction $interaction)
    {
        $interaction->recordActivity('<strong>' . auth()->user()->name . '</strong> adicionou uma interação à este chamado');
    }
}
