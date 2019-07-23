@extends('layouts.app')

@section('content')

<div class="container">
    <form action="/tickets" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Criar chamado</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-6">
                        <label for="title">Título</label>
                        <input 
                            type="text"
                            id="title"
                            name="title"
                            class="form-control"
                            placeholder="Título"
                        />
                    </div>
                    <div class="col-6">
                        <label for="area">Selecione a área de atendimento</label>
                        <select name="area" id="area" class="form-control">
                            @foreach($profiles as $profile)
                                <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="col">
                        <label for="content">Conteúdo</label>
                        <textarea
                            name="content"
                            id="content"
                            rows="10"
                            placeholder="Conteúdo do chamado"
                            class="form-control"
                        ></textarea>
                    </div>
                </div>  
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </form>
</div>

@endsection