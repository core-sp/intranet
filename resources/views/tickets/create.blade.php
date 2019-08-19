@extends('layouts.app')

@section('content')

<div class="container mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/tickets">Chamados</a></li>
            <li class="breadcrumb-item active" aria-current="page">Criar Chamado</li>
        </ol>
    </nav>
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