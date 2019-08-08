@if(count($ticket->respondents) === 0)
    <h5 class="mb-0">
        <span class="badge badge-dark font-weight-normal">Aguardando atribuição</span>
    </h5>
@else
    <h5 class="mb-0">
        <span class="{{ badge($ticket->status) }} font-weight-normal">{{ $ticket->status }}</span>
        <span class="badge badge-secondary">{{ $ticket->interactions->count() }}</span>
    </h5>
@endif