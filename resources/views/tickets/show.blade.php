@extends('layouts.app')

@section('content')

<div class="container mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/tickets">Chamados</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chamado</li>
        </ol>
    </nav>
</div>
@if($ticket->status !== 'Concluído')
    <div class="container mb-3">
        @can('interact', $ticket)
            <a 
                class="btn btn-primary dropdown-toggle"
                data-toggle="collapse"
                href="#collapse-interaction"
                role="button"
            >
                Responder
            </a>
            @if(changeStatusBtn($ticket))
            <form action="{{ $ticket->path() . '/update-status' }}" method="POST" class="d-inline">
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
        @endcan
    </div>
@endif

<div class="container">
    <div class="row">
        <div class="col-9" style="padding-left: 7.5px; padding-right: 7.5px;">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Histórico de interações</h4>
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
                                <div class="direct-chat-text {{ $interaction->user->isRespondent($ticket) ? 'bg-info' : '' }}">
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
        <div class="col-3" style="padding-left: 7.5px; padding-right: 7.5px;">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Atividades</h4>
                </div>
                <div class="card-body">
                    <ul class="list-activities">
                        @foreach ($ticket->activities as $activity)
                            <li class="{{ $loop->last ? 'pb-0' : '' }}">{!! $activity->description !!}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@can('assign', $ticket)
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Alterar atribuições</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form action="{{ $ticket->path() . '/update-respondent' }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mb-0">
                                <label for="respondent">Atribuir usuário ao chamado</label>
                                <select name="respondent_id" id="respondent" class="form-control" onchange="this.form.submit()">
                                    <option value="" disabled selected>Selecione o usuário...</option>
                                    @foreach($ticket->possibleRespondents() as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <form action="{{ $ticket->path() . '/update-profile' }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mb-0">
                                <label for="profile">Ou então, atribua o chamado à outra área</label>
                                <select name="profile_id" id="profile" class="form-control" onchange="this.form.submit()">
                                    @foreach ($ticket->possibleProfiles() as $profile)
                                        <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcan

@endsection