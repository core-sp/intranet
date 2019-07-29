@extends('layouts.app')

@section('content')

@if(Session::has('message'))
    <div class="container mb-3">
        <div class="alert {{ Session::has('class') ? Session::get('class') : 'alert-info' }}">
            <p class="mb-0"><strong>{{ Session::get('message') }}</strong></p>
        </div>
    </div>
@endif

<div class="container mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/tickets">Chamados</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chamado</li>
        </ol>
    </nav>
</div>
@if($ticket->canInteract() || changeStatusBtn($ticket))
    <div class="container mb-3">
        @if($ticket->canInteract())
            <a 
                class="btn btn-primary"
                data-toggle="collapse"
                href="#collapse-interaction"
                role="button"
            >
                Responder
            </a>
            @if(changeStatusBtn($ticket))
            <form action="{{ $ticket->path() }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="{{ changeStatusBtn($ticket)['value'] }}">
                <button 
                    type="submit"
                    class="btn {{ changeStatusBtn($ticket)['class'] }}"
                >
                    {{ changeStatusBtn($ticket)['text'] }}
                </button>
            </form>
            @endif
            <div class="collapse mt-2" id="collapse-interaction">
                <div class="card card-body">
                    <form action="{{ $ticket->path() . '/interactions' }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                        <div class="form-group">
                            <textarea
                                name="content"
                                id="content"
                                rows="5"
                                placeholder="Descrição"
                                class="form-control"
                            ></textarea>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">Responder</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endif

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Histórico de interações</h3>
        </div>
        <div class="card-body">
            @foreach($ticket->interactions as $interaction)
                <div class="row mb-4 mt-1 mx-2">
                    <div class="direct-chat-msg {{ auth()->id() === $interaction->user->id ? '' : 'right' }}">
                        <div class="direct-chat-img text-center">
                            <p><i>{{ dateAndHour($interaction->created_at) }}</i></p>
                            <img src="{{ gravatar_url($interaction->user->email) }}" />
                            <p class="m-0"><strong>({{ $interaction->user->name }} - {{ $interaction->user->profile->name }})</strong></p>
                        </div>
                        <div class="direct-chat-text">
                            <h5 class="mt-2">{{ $interaction->title }}</h5>
                            <p class="mt-2 mb-2">{{ $interaction->content }}</p>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
            <div class="row pt-1 mx-2 mb-2">
                <div class="direct-chat-msg {{ auth()->id() === $ticket->user->id ? '' : 'right' }}">
                    <div class="direct-chat-img text-center">
                        <p><i>{{ dateAndHour($ticket->created_at) }}</i></p>
                        <img src="{{ gravatar_url($ticket->user->email) }}" />
                        <p class="m-0"><strong>({{ $ticket->user->name }} - {{ $ticket->user->profile->name }})</strong></p>
                    </div>
                    <div class="direct-chat-text">
                        <h5 class="mt-2">{{ $ticket->title }}</h5>
                        <p class="mt-2 mb-2">{{ $ticket->content }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection