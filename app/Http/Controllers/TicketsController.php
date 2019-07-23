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

    public function store(Ticket $ticket)
    {
        auth()->user()->tickets()->create();

        return redirect('tickets');
    }
}
