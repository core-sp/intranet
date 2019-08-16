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
                                <th>Prioridade</th>
                                <th>Concluído por:</th>
                                <th>Data de conclusão</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pagination = $profile->completedTickets() as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td><a href="{{ $ticket->path() }}">{{ $ticket->title }}</a></td>
                                    <td class="{{ bgPriority($ticket->priority) }}">{{ $ticket->priority }}</td>
                                    <td>{{ $ticket->respondent->name }}</td>
                                    <td><strong class="text-muted">{{ dateAndHour($ticket->updated_at) }}</strong></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Nenhum chamado concluído ainda.</td>
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