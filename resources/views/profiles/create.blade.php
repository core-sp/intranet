@extends('layouts.app')

@section('content')

<div class="container mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/users">Usuários</a></li>
            <li class="breadcrumb-item active" aria-current="page">Criar Usuário</li>
        </ol>
    </nav>
</div>
<div class="container">
    <form action="/profiles" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nome</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                placeholder="Nome do perfil"
            >
        </div>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </form>
</div>

@endsection