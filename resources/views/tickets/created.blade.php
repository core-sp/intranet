@extends('layouts.app')

@section('content')

<div class="container mb-3">
    <div class="d-flex w-100">
        <nav aria-label="breadcrumb" class="flex-one">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/tickets">Chamados</a></li>
                <li class="breadcrumb-item active" aria-current="page">Meus Chamados</li>
            </ol>
        </nav>
        <div class="refresh">
            <button onClick="window.location.reload();" class="btn btn-success"><p class="mb-0"><i class="fas fa-redo"></i>&nbsp;&nbsp;Atualizar</p></button>
        </div>
    </div>
</div>
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <a href="/tickets" class="btn btn-secondary">
                Lista de Chamados&nbsp;&nbsp;<counter count="{{ auth()->user()->profile->ticketsCount() }}" classes="badge badge-light"></counter>
            </a>
            <a href="/tickets/created-and-completed" class="btn btn-dark">Meus Chamados Concluídos</a>
        </div>
        <div class="col text-right">
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
                                <th>Prioridade</th>
                                <th>Situação</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pagination = auth()->user()->tickets()->paginate(10) as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td><a href="{{ $ticket->path() }}">{{ $ticket->title }}</a></td>
                                    <td>{{ $ticket->profile->name }}</td>
                                    <td class="{{ bgPriority($ticket->priority) }}">{{ $ticket->priority }}</td>
                                    <td>
                                        @include('tickets.inc.situation')
                                    </td>
                                    <td>
                                        @if($ticket->status === 'Concluído')
                                            <p class="mb-0 text-muted">
                                                <small>
                                                    <i class="far fa-check-square"></i> CONCLUÍDO
                                                </small>
                                            </p>
                                        @else
                                            @if(!count($ticket->interactions))
                                                <p class="mb-0">
                                                    <small>
                                                        <i class="far fa-circle"></i> AGUARDANDO INTERAÇÃO
                                                    </small>
                                                </p>
                                            @else
                                                @include('tickets.inc.status')
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Nenhum chamado criado ainda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $pagination->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection