@extends('layouts.app')

@section('content')

<div class="container mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/users">Usuários</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Usuário</li>
        </ol>
    </nav>
</div>
@include('errors')
<div class="container">
    <form action="{{ $user->path() }}" method="POST">
        @method('PATCH')
        @include('users.form', [
            'title' => 'Editar Usuário',
            'password' => false
        ])
    </form>
</div>

@endsection