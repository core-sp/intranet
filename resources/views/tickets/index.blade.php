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
            <a href="/tickets/created" class="btn btn-secondary">Meus Chamados</a>
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
                    @forelse(auth()->user()->ticketsFromProfile() as $ticket)
                        <h6 class="mb-2"><a href="{{ $ticket->path() }}"><strong>#{{ $ticket->id }} - {{ $ticket->title }}</strong></a></h6>
                        <p class="mb-0" style="line-height:1.1;">
                            <small class="font-weight-light">Emitido por: <span class="font-weight-bold">{{ $ticket->user->name }} ({{ $ticket->user->profile->name }})</span></small>
                        </p>
                        <p class="mb-0" style="line-height:1.1;">
                            <small class="font-weight-light">Criado em: <span class="font-weight-bold">{{ onlyDate($ticket->created_at) }}</span></small>
                        </p>
                        <p class="mb-0" style="line-height:1.1;">
                            <small class="font-weight-light">Última interação: <span class="font-weight-bold">{{ onlyDate($ticket->updated_at) }}</span></small>
                        </p>
                        @if(count($ticket->respondents) === 0)
                            <p class="mb-0" style="line-height:1.1;">
                                <small class="font-weight-bold text-danger"><i class="fas fa-exclamation-circle"></i> NECESSITA ATRIBUIÇÃO</small>
                            </p>
                        @endif
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
                                <th>Situação</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(auth()->user()->respondentTicketsWithPagination() as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>
                                        <a href="{{ $ticket->path() }}">{{ $ticket->title }}</a>
                                        <p class="mb-0" style="line-height:1.1;">
                                            <small class="font-weight-light">Criado em: <span class="font-weight-bold">{{ dateAndHour($ticket->created_at) }}</span></small>
                                        </p>
                                        <p class="mb-0" style="line-height:1.1;">
                                            <small class="font-weight-light">Última interação: <span class="font-weight-bold">{{ dateAndHour($ticket->updated_at) }}</span></small>
                                        </p>
                                    </td>
                                    <td>
                                        @include('tickets.inc.situation')
                                    </td>
                                    <td>
                                        @if(count($ticket->respondents) === 0)
                                            <p class="mb-0">
                                                <small>
                                                    <i class="far fa-circle"></i> AGUARDANDO INTERAÇÃO
                                                </small>
                                            </p>
                                        @else
                                            @include('tickets.inc.status')
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Nenhum chamado atribuído à você.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ auth()->user()->respondentTicketsWithPagination()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection