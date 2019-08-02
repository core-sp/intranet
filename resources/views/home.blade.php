@extends('layouts.app')

@section('content')
<div class="container mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
    </nav>
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
                        <li><a href="/tickets">Chamados da área: {{ auth()->user()->profile->name }}</a></li>
                        <li><a href="/tickets/created">Meus chamados</a></li>
                        <li><a href="/tickets/create">Criar chamado</a></li>
                    </ul>
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
