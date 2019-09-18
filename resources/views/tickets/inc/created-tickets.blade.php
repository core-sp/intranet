<tr>
    <td>{{ $ticket->id }}</td>
    <td><a href="{{ $ticket->path() }}">{{ $ticket->title }}</a></td>
    <td>{{ $ticket->profile->name }}</td>
    <td class="{{ bgPriority($ticket->priority) }}">{{ $ticket->priority }}</td>
    <td>
        @include('tickets.inc.situation')
    </td>
    <td>
        @if($ticket->status === 'Concluído')
            <p class="mb-0 text-muted">
                <small>
                    <strong><i class="far fa-check-square"></i> CONCLUÍDO</strong>
                </small>
            </p>
        @else
            @if(!count($ticket->interactions))
                <p class="mb-0">
                    <small>
                        <i class="far fa-circle"></i> AGUARDANDO INTERAÇÃO
                    </small>
                </p>
            @else
                @include('tickets.inc.status')
            @endif
        @endif
    </td>
</tr>