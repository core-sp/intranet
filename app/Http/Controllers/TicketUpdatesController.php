<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class TicketUpdatesController extends Controller
{
    public function updateStatus(Ticket $ticket)
    {
        $this->protectionToChangeStatus($ticket);

        $ticket->changeStatus(request('status'));

        return $this->redirect($ticket->path(), 'Chamado ' . request('status'), 'alert-success');
    }

    public function updateRespondent(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->assignRespondents(request('user_id'));

        return $this->redirect($ticket->path(), 'Usuário atribuído ao chamado com sucesso', 'alert-success');
    }

    public function updateProfile(Ticket $ticket)
    {
        $this->authorize('assign', $ticket);

        if(request('profile_id') === $ticket->profile->id) {
            abort(403);
        } 

        $ticket->changeProfile(request('profile_id'));

        return $this->redirect('/', 'Ticket atribuído à outra área', 'alert-info');
    }

    protected function protectionToChangeStatus($ticket)
    {
        $this->authorize('interact', $ticket);

        auth()->user()->is($ticket->owner) && request('status') === 'Encerrado' ?? abort(403);
        
        auth()->user()->is($ticket->respondent) && !auth()->user()->is($ticket->owner) && request('status') === 'Concluído' ?? abort(403);
    }

    protected function redirect($path, $message, $class)
    {
        return redirect($path)->with([
            'message' => $message,
            'class' => $class
        ]);
    }
}
