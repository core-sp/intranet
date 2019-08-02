<h5 class="mb-0">
    <span class="{{ badge($ticket->status) }} font-weight-normal">{{ $ticket->status }}</span>
    <span class="badge badge-secondary">{{ $ticket->interactions->count() }}</span>
</h5>