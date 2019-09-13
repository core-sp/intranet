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
            'content' => 'required'
        ]);
    }

    public function store(Ticket $ticket)
    {
        if($ticket->status === 'Concluído')
            abort(403);
    
        $this->authorize('interact', $ticket);

        $interaction = $ticket->addInteraction($this->validateRequest());

        request('fileName') !== null ? $interaction->addAttachment(request('fileName')) : '';

        return redirect($ticket->path())->with([
            'message' => 'Resposta emitida com sucesso',
            'class' => 'alert-success'
        ]);
    }
}
