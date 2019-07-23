@extends('layouts.app')

@section('content')

<div class="container">
    <ul class="list-group">
        @forelse($tickets as $ticket)
            <li class="list-group-item">{{ $ticket->title }}</li>
        @empty
            <li class="list-group-item">Nenhum ticket criado ainda.</li>
        @endforelse
    </ul>
</div>

@endsection