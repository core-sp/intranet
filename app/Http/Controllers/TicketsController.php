<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Profile;

class TicketsController extends Controller
{
    public function index()
    {
        $tickets = auth()->user()->tickets;

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $profiles = Profile::select('id', 'name')->get();

        return view('tickets.create', compact('profiles'));
    }

    public function validateRequest()
    {   
        return request()->validate([
            'title' => 'required',
            'profile_id' => 'required',
            'priority' => 'required',
            'content' => 'required|min:10'
        ]);
    }

    public function store()
    {
        $ticket = auth()->user()->tickets()->create($this->validateRequest());

        return redirect($ticket->path())->with([
            'message' => 'Chamado criado com sucesso',
            'class' => 'alert-success'
        ]);
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        return view('tickets.show', compact('ticket'));
    }

    public function update(Ticket $ticket)
    {
        $ticket->changeStatus(request('status'));

        return redirect($ticket->path())->with([
            'message' => 'Chamado ' . request('status'),
            'class' => 'alert-info'
        ]);
    }
}
