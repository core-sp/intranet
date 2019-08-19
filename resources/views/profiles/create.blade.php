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
    <form action="/profiles" method="POST" class="any-form">
        @csrf
        <div class="card">
            <h5 class="card-header">
                Criar Perfil
            </h5>
            <div class="card-body">
                <div class="form-group mb-0">
                    <label for="name">Nome</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        placeholder="Nome do perfil"
                    >
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary any-submit-button"><i class="spinner fa fa-spinner fa-spin"></i> Salvar</button>
            </div>
        </div>
    </form>
</div>

@endsection