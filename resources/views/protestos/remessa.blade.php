@extends('layouts.app', ['title' => 'Protestos'])

@section('content')

<div class="container mb-3">
    <breadcrumb>
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('protestos.index') }}">Protestos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Remessa</li>
    </breadcrumb>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Enviar Remessa
                </div>
                <div class="card-body">
                    <form method="POST" id="form-remessa" action="{{ route('remessa.send') }}" enctype="multipart/form-data">
                        @csrf
                        <upload-csv>
                            @csrf
                        </upload-csv>
                        <div class="form-group mt-2 mb-0">
                            <input type="submit" value="Enviar" class="btn btn-primary">
                        </div>
                    </form>
                    <div class="alert alert-info mt-3" id="submit-remessa">
                        <p class="mb-0">Processando o envio... aguarde.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection