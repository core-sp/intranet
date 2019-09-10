@extends('layouts.app')

@section('content')

<div class="container mb-3">
    <breadcrumb>
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/tickets">Chamados</a></li>
        <li class="breadcrumb-item active" aria-current="page">Criar Chamado</li>
    </breadcrumb>
</div>
<div class="container">
    <form action="/tickets" method="POST" class="any-form">
        @csrf
        @include('tickets.form', [
            'title' => 'Criar Chamado'
        ])
    </form>
</div>

@endsection