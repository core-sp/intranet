@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0"><i class="fas fa-ticket-alt"></i> Chamados</h3>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li><a href="/tickets">Ver lista de chamados</a></li>
                        <li><a href="/tickets/create">Criar chamado</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
