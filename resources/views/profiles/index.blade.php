@extends('layouts.app')

@section('content')

@if(Session::has('message'))
    <div class="container mb-3">
        <div class="alert {{ Session::has('class') ? Session::get('class') : 'alert-info' }}">
            <p class="mb-0"><strong>{{ Session::get('message') }}</strong></p>
        </div>
    </div>
@endif

<div class="container mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Perfis</li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="row mb-2">
        <div class="col text-right">
            <a href="/profiles/create" class="btn btn-primary">Criar Perfil</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h5>Lista de perfis</h5>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-bordered mb-5">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Nº de usuários</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profiles as $profile)
                        <tr>
                            <td>{{ $profile->id }}</td>
                            <td>{{ $profile->name }}</td>
                            <td>{{ count($profile->users) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum perfil criado ainda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection