@extends('layouts.app', ['title' => 'Protestos'])

@section('content')

<div class="container mb-3">
    <breadcrumb>
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('protestos.index') }}">Protestos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Retorno</li>
    </breadcrumb>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Sucessos
                </div>
                <div class="card-body">
                    @if (empty($erros_sucessos['sucessos']))
                        Nenhum título enviado. Confira o detalhe dos erros abaixo.
                    @else
                        @foreach ($erros_sucessos['sucessos'] as $sucesso)
                            <strong>Comarca:</strong> {{$sucesso['codigo_comarca']}}<br>
                            <strong>Títulos enviados:</strong> {{ $sucesso['titulos_enviados'] }}
                            <hr>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    Erros
                </div>
                <div class="card-body">
                    @if (empty($erros_sucessos['erros']))
                        Nenhum erro de processamento.
                    @else
                        @foreach ($erros_sucessos['erros'] as $erro)
                            <strong>Comarca:</strong> {{$erro['codigo_comarca']}}<br>
                            <strong>Ocorrência:</strong> {{ $erro['ocorrencia'] }}<br>
                            <strong>Detalhe:</strong> {{ $erro['info'] }}
                            <hr>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection