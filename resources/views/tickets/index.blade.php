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
    <div class="row mb-2">
        <div class="col text-right">
            <a href="/tickets/create" class="btn btn-primary">Novo Chamado</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h5>Seus chamados</h5>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-bordered mb-5">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
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
                                <h4>
                                    <span class="{{ badge($ticket->status) }} font-weight-normal">{{ $ticket->status }}</span>
                                    <span class="badge badge-secondary">{{ $ticket->interactions->count() }}</span>
                                </h4>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum ticket criado ainda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h5>Chamados solicitados à sua área</h5>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Área requisitada</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(auth()->user()->ticketsParticipating() as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td><a href="{{ $ticket->path() }}">{{ $ticket->title }}</a></td>
                            <td>{{ $ticket->profile->name }}</td>
                            <td>
                                <h4>
                                    <span class="{{ badge($ticket->status) }} font-weight-normal">{{ $ticket->status }}</span>
                                    <span class="badge badge-secondary">{{ $ticket->interactions->count() }}</span>
                                </h4>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum ticket criado ainda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection