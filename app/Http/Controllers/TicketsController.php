<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Profile;
use App\User;

class TicketsController extends Controller
{
    public function index()
    {
        return view('tickets.index');
    }

    public function created()
    {
        return view('tickets.created');
    }

    public function create()
    {
        $profiles = Profile::select('id', 'name')->get();

        return view('tickets.create', compact('profiles'));
    }

    protected function validateRequest()
    {   
        return request()->validate([
            'title' => 'required',
            'profile_id' => 'required',
            'priority' => 'required',
            'content' => 'required|min:10'
        ]);
    }

    protected function redirect($path, $message, $class)
    {
        return redirect($path)->with([
            'message' => $message,
            'class' => $class
        ]);
    }

    public function store()
    {        
        $ticket = auth()->user()->tickets()->create($this->validateRequest());

        return $this->redirect($ticket->path(), 'Chamado criado com sucesso', 'alert-success');
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $possibleRespondents = User::select('id', 'name')->where('profile_id', $ticket->profile->id)->get();

        return view('tickets.show', compact('ticket', 'possibleRespondents'));
    }

    public function update(Ticket $ticket)
    {
        if(request('status') !== null) {
            $this->updateStatus($ticket);

            return $this->redirect($ticket->path(), 'Chamado ' . request('status'), 'alert-success');
        } else {
            $this->updateAssignedRespondent($ticket);

            return $this->redirect($ticket->path(), 'Usuário atribuído ao chamado com sucesso', 'alert-success');
        }        
    }

    protected function updateStatus($ticket)
    {
        $this->protectionToChangeStatus($ticket);

        $ticket->changeStatus(request('status'));
    }

    protected function updateAssignedRespondent($ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->assignRespondent(request('respondent_id'));
    }

    protected function protectionToChangeStatus($ticket)
    {
        $this->authorize('interact', $ticket);

        if(auth()->user()->is($ticket->owner) && request('status') === 'Encerrado')
            abort(403);
        elseif(auth()->user()->is($ticket->respondent) && !auth()->user()->is($ticket->owner) && request('status') === 'Concluído')
            abort(403);
    }
}
