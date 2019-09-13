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

    public function createdAndCompleted()
    {
        return view('tickets.created-and-completed');
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
            'content' => 'required'
        ]);
    }

    public function store()
    {
        $ticket = auth()->user()->tickets()->create($this->validateRequest());

        request('fileName') !== null ? $ticket->addAttachment(request('fileName')) : '';

        return redirect($ticket->path())->with([
            'message' => 'Chamado criado com sucesso',
            'class' => 'alert-success'
        ]);
    }

    public function show(Ticket $ticket)
    {
        $profiles = Profile::select('id', 'name')->get();

        return view('tickets.show', compact('ticket', 'profiles'));
    }
}
