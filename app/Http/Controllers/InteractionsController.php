<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interaction;
use App\Ticket;

class InteractionsController extends Controller
{
    public function create()
    {
        $this->authorize('interact');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'user_id' => 'required',
            'ticket_id' => 'required',
            'content' => 'required|min:10'
        ]);
    }

    public function store(Ticket $ticket)
    {
        $this->authorize('interact', $ticket);

        $ticket->addInteraction($this->validateRequest());

        return redirect($ticket->path())->with([
            'message' => 'Resposta emitida com sucesso',
            'class' => 'alert-success'
        ]);
    }
}
