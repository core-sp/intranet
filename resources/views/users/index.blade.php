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
    <div class="row mb-3">
        <div class="col">
            <a href="/users/create" class="btn btn-primary">Novo Usuário</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <h5 class="card-header">
                    Usuários
                </h5>
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead class="thead">
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
    </div>
</div>

@endsection