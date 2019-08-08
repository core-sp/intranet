@if(auth()->user()->is($ticket->owner))
    <p class="mb-0">
        <small>
            @if($ticket->interactions->isEmpty() || $ticket->interactions->first()->user_id == auth()->id())
                <i class="fas fa-circle"></i> AGUARDANDO INTERAÇÃO
            @else
                <span class="text-danger font-weight-bold"><i class="fas fa-exclamation-circle"></i> NECESSITA INTERAÇÃO</span>
            @endif
        </small>
    </p>
@else
    <p class="mb-0">
        <small>
            @if($ticket->interactions->isEmpty() || $ticket->interactions->first()->user_id == $ticket->owner->id)
                <span class="text-danger font-weight-bold"><i class="fas fa-exclamation-circle"></i> NECESSITA INTERAÇÃO</span>
            @else
                <i class="fas fa-circle"></i> AGUARDANDO INTERAÇÃO
            @endif
        </small>
    </p>
@endif