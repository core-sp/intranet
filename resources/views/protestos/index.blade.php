@extends('layouts.app', ['title' => 'Protestos'])

@section('content')

<div class="container mb-3">
    <breadcrumb>
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Protestos</li>
    </breadcrumb>
</div>
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('protestos.remessa') }}" class="btn btn-primary">Nova Remessa</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Relatório por Comarcas
                </div>
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead class="thead">
                            <tr>
                                <th>Código</th>
                                <th>Comarca</th>
                                <th>Remessa</th>
                                <th>Títulos Protestados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comarcas as $comarca)
                                <tr>
                                    <td>{{ $comarca->codigo }}</td>
                                    <td>{{ $comarca->comarca }}</td>
                                    <td>{{ $comarca->nr_remessa }}</td>
                                    <td>{{ $comarca->count_titulos }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection