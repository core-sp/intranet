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
    <form action="/users" method="POST">
        @csrf
        @include('users.form', [
            'title' => 'Criar Usuário'
        ])
    </form>
</div>

@endsection