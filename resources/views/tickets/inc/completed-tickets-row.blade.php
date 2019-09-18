<tr>
    <td>{{ $ticket->id }}</td>
    <td><a href="{{ $ticket->path() }}">{{ $ticket->title }}</a></td>
    <td class="{{ bgPriority($ticket->priority) }}">{{ $ticket->priority }}</td>
    <td>{!! isset($ticket->respondent->name) ? $ticket->respondent->name : '<i>Sem atribuição</i>' !!}</td>
    <td><strong class="text-muted">{{ dateAndHour($ticket->updated_at) }}</strong></td>
</tr>