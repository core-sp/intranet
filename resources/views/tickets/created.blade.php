@extends('layouts.app')

@section('content')

<div class="container mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/tickets">Chamados</a></li>
            <li class="breadcrumb-item active" aria-current="page">Meus Chamados</li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <a href="/tickets" class="btn btn-secondary">Lista de Chamados</a>
            <a href="/tickets/create" class="btn btn-primary">Novo Chamado</a>
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
                                <th>Situação</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(auth()->user()->tickets as $ticket)
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
                                            @include('tickets.inc.situation')
                                        @endif
                                    </td>
                                    <td>
                                        @if($ticket->interactions->first() !== null)
                                            @include('tickets.inc.status')
                                        @else
                                            <p class="mb-0">
                                                <small>
                                                    <i class="far fa-circle"></i> AGUARDANDO ATRIBUIÇÃO
                                                </small>
                                            </p>
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