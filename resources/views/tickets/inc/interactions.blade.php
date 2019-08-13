<p class="mb-0" style="line-height:1.1;">
    <small class="font-weight-light">Criado em: <span class="font-weight-bold">{{ dateAndHour($ticket->created_at) }}</span></small>
</p>
<p class="mb-0" style="line-height:1.1;">
    <small class="font-weight-light">Última interação: <span class="font-weight-bold">{{ dateAndHour($ticket->updated_at) }}</span></small>
</p>