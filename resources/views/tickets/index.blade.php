@extends('layouts.app')

@section('content')

<div class="container mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chamados</li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <a href="/tickets/create" class="btn btn-primary">Novo Chamado</a>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-4" style="padding-left:7.5px;padding-right:7.5px;">
            <div class="card">
                <h5 class="card-header">
                    Chamados do {{ auth()->user()->profile->name }}
                </h5>
                <div class="card-body">
                    @forelse(auth()->user()->ticketsWithoutAttribution() as $ticket)
                        <p class="mb-0">
                            <a href="{{ $ticket->path() }}"><strong>#{{ $ticket->id }} - {{ $ticket->title }}</strong></a><br>
                            <small style="font-weight:300;">{{ $ticket->user->name }} - {{ $ticket->user->profile->name }} ({{ dateAndHour($ticket->created_at) }})</small>
                        </p>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="mb-0">Nada para mostrar aqui.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <h5 class="card-header">
                    Chamados atribuídos a você
                </h5>
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead class="thead">
                            <tr>
                                <th>#</th>
                                <th>Título</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(auth()->user()->ticketsResponding() as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td><a href="{{ $ticket->path() }}">{{ $ticket->title }}</a></td>
                                    <td>
                                        <h5 class="mb-0">
                                            <span class="{{ badge($ticket->status) }} font-weight-normal">{{ $ticket->status }}</span>
                                            <span class="badge badge-secondary">{{ $ticket->interactions->count() }}</span>
                                        </h5>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Nenhum chamado atribuído à você</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <h5 class="card-header">
                    Seus chamados
                </h5>
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead class="thead">
                            <tr>
                                <th>#</th>
                                <th>Título</th>
                                <th>Área requisitada</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td><a href="{{ $ticket->path() }}">{{ $ticket->title }}</a></td>
                                    <td>{{ $ticket->profile->name }}</td>
                                    <td>
                                        @if($ticket->respondent_id === null)
                                            <h5 class="mb-0">
                                                <span class="badge badge-dark font-weight-normal">Aguardando atribuição</span>
                                            </h5>
                                        @else
                                            <h5 class="mb-0">
                                                <span class="{{ badge($ticket->status) }} font-weight-normal">{{ $ticket->status }}</span>
                                                <span class="badge badge-secondary">{{ $ticket->interactions->count() }}</span>
                                            </h5>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Nenhum chamado criado ainda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection