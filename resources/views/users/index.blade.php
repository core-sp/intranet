@extends('layouts.app', ['title' => 'Usuários'])

@section('content')

<div class="container mb-3">
    <breadcrumb>
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Usuários</li>
    </breadcrumb>
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
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        {{ $user->name }} {!! $user->is_admin ? '<small><strong>Administrador</strong></small>' : '' !!}
                                    </td>
                                    <td>{{ isset($user->profile) ? $user->profile->name : 'Sem Perfil' }} {!! $user->is_coordinator ? '<small><i>(Coordenador)</i></small>' : '' !!}</td>
                                    <td>
                                        <a href="{{ $user->path() . '/edit' }}" class="btn btn-sm btn-primary">Editar</a>
                                        <a href="{{ $user->path() . '/change-password' }}" class="btn btn-sm btn-secondary">Alterar senha</a>
                                        <form action="/users/{{ $user->id }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-sm btn-danger any-delete-button" value="Deletar" />
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Nenhum usuário criado ainda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $users->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection