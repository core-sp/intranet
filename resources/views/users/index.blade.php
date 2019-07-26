@extends('layouts.app')

@section('content')

<div class="container mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Usuários</li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="row mb-2">
        <div class="col text-right">
            <a href="/users/create" class="btn btn-primary">Novo Usuário</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h5>Lista de usuários</h5>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-bordered mb-5">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Usuário</th>
                        <th>Perfil</th>
                        <th>Coordenador</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->profile->name }}</td>
                            <td>{{ $user->isCoordinator() ? 'Sim' : 'Não' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum usuário criado ainda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection