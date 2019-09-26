@extends('layouts.app', ['title' => 'Criar Usuário'])

@section('content')

<div class="container mb-3">
    <breadcrumb>
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/users">Usuários</a></li>
        <li class="breadcrumb-item active" aria-current="page">Criar Usuário</li>
    </breadcrumb>
</div>
@include('errors')
<div class="container">
    <form action="/users" method="POST" class="any-form">
        @include('users.form', [
            'user' => new App\User,
            'title' => 'Criar Usuário',
            'password' => true
        ])
    </form>
</div>

@endsection