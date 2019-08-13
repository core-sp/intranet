@if(count($ticket->interactions) > 0 && $ticket->interactions->first()->user->id !== auth()->id())
    <p class="mb-0">
        <small>
            <span class="text-danger font-weight-bold"><i class="fas fa-exclamation-circle"></i> NECESSITA INTERAÇÃO</span>
        </small>
    </p>
@else
    <p class="mb-0">
        <small>
            <i class="fas fa-circle"></i> AGUARDANDO INTERAÇÃO
        </small>
    </p>
@endif