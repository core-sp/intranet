@extends('layouts.app')

@section('content')

<div class="container mb-3">
    <div class="d-flex w-100">
        <breadcrumb>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/tickets">Chamados</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chamados Concluídos</li>
        </breadcrumb>
        <refresh-button></refresh-button>
    </div>
</div>
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <a href="/tickets" class="btn btn-secondary">
                Lista de Chamados&nbsp;&nbsp;<counter count="{{ auth()->user()->profile->ticketsCount() }}" classes="badge badge-light"></counter>
            </a>
        </div>
        <div class="col text-right">
            <a href="/tickets/create" class="btn btn-primary">Novo Chamado</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <h5 class="card-header">
                    Chamados Concluídos do {{ auth()->user()->profile->name }}
                </h5>
                <div class="card-body">
                    <div class="col-6 nopadding mb-3 position-relative">
                        <form method="get">
                            <div class="input-group mb-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder='Buscar em "Chamados Concluídos do {{ auth()->user()->profile->name }}"...'
                                    name="q"
                                    value="{{ !empty(app('request')->input('q')) ? app('request')->input('q') : '' }}"
                                />
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Pesquisar</button>
                                </div>
                            </div>
                        </form>
                        @if(app('request')->input('q'))
                            <div class="clean-search">
                                <a href="{{ auth()->user()->profile->path() . '/tickets-completed' }}"><i class="fas fa-times"></i> Limpar filtro</a>
                            </div>
                        @endif
                    </div>
                    @if(!empty(app('request')->input('q')))
                        <p class="mb-1"><small><i>{{ $profile->searchCompletedTickets(app('request')->input('q'))->count() }} resultado{{ $profile->searchCompletedTickets(app('request')->input('q'))->count() > 1 ? 's' : '' }} para a busca:</i> <strong> {{ app('request')->input('q') }}</strong></small></p>
                    @endif
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
                            @if(app('request')->input('q'))
                                @forelse($profile->searchCompletedTickets(app('request')->input('q')) as $ticket)
                                    @include('tickets.inc.completed-tickets-row')
                                @empty
                                    <tr>
                                        <td colspan="5">Nenhum chamado encontrado.</td>
                                    </tr>
                                @endforelse
                            @else
                                @forelse($pagination = $profile->completedTickets() as $ticket)
                                    @include('tickets.inc.completed-tickets-row')
                                @empty
                                    <tr>
                                        <td colspan="5">Nenhum chamado concluído ainda.</td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ isset($pagination) ? $pagination->links() : '' }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection