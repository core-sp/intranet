@if(!isset($ticket->respondent) && $ticket->status !== 'Concluído')
    <h5 class="mb-0">
        <span class="badge badge-dark font-weight-normal">Aguardando atribuição</span>
    </h5>
@else
    <h5 class="mb-0">
        <span class="{{ badge($ticket->status) }} font-weight-normal">{{ $ticket->status }}</span>
        <counter count="{{ $ticket->interactions->count() }}" classes="badge badge-secondary"></counter>
    </h5>
@endif