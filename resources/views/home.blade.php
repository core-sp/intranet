@extends('layouts.app', ['title' => 'Home'])

@section('content')
<div class="container mb-3">
    <div class="d-flex w-100">
        <breadcrumb>
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </breadcrumb>
        <refresh-button></refresh-button>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        @can('create', 'App\User')
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-users"></i> Usuários</h4>
                </div>
                <div class="card-body">
                    <ul class="mb-0 list-unstyled">
                        <li><a href="/users">Todos os usuários</a></li>
                        <li><a href="/users/create">Criar usuário</a></li>
                        <li><a href="/profiles">Perfis</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @endcan
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-ticket-alt"></i> Chamados</h4>
                </div>
                <div class="card-body">
                    <ul class="mb-0 list-unstyled">
                        <li>
                            <a href="/tickets">Chamados da área: {{ auth()->user()->profile->name }}</a>
                            <counter count="{{ auth()->user()->profile->ticketsCount() }}" classes="badge badge-secondary"></counter>
                        </li>
                        <li>
                            <a href="/tickets/created">Meus chamados</a>
                            <counter count="{{ auth()->user()->ticketsCount() }}" classes="badge badge-secondary"></counter>
                        </li>
                        <li><a href="/tickets/create">Criar chamado</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="far fa-file-alt"></i> Protestos</h4>
                </div>
                <div class="card-body">
                    <div class="mb-0 list-unstyled">
                        <li><a href="{{ route('protestos.index') }}">Protestos</a></li>
                        <li><a href="{{ route('protestos.remessa') }}">Nova remessa</a></li>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-globe"></i> Portal</h4>
                </div>
                <div class="card-body">
                    <ul class="mb-0 list-unstyled">
                        <li><a href="https://core-sp.org.br" target="_blank">Visitar portal</a></li>
                        <li><a href="https://core-sp.org.br/admin" target="_blank">Painel de administrador</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
