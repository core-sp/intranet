@extends('layouts.app')

@section('content')

<div class="container mb-3">
    <breadcrumb>
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Alterar senha</li>
    </breadcrumb>
</div>
@include('errors')
<div class="container">
    <form method="POST">
        @csrf
        @method('PATCH')
        <div class="card">
            <h5 class="card-header">
                Alterar senha
            </h5>
            <div class="card-body">
                <div class="form-row">
                    <div class="col">
                        <label for="password">Senha</label>
                        <input
                            id="password"
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            required
                            autocomplete="new-password"
                        />
                    </div>
                    <div class="col">
                        <label for="password-confirm">Confirme a senha</label>
                        <input
                            id="password-confirm"
                            type="password"
                            class="form-control"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                        />
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="/" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </form>
</div>

@endsection