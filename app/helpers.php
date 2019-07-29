<?php

function ticketsPriorities()
{
    return [
        'Muito Baixa',
        'Baixa',
        'Média',
        'Alta',
        'Muito Alta'
    ];
}

function dateAndHour($date)
{
    return $date->format('d\/m\/Y\, \à\s H:i');
}

function gravatar_url($email)
{
    $email = md5($email);
    return "https://gravatar.com/avatar/{$email}?s=40&d=https://s3.amazonaws.com/laracasts/images/default-square-avatar.jpg";
}

function badge($status)
{
    switch ($status) {
        case 'Em aberto':
            return 'badge badge-info text-white';
        break;

        case 'Encerrado':
            return 'badge badge-dark';
        break;

        case 'Concluído':
            return 'badge badge-success';
        break;
    }
}

function changeStatusBtn($ticket)
{
    if(auth()->user()->is($ticket->owner)) {
        $data = [
            'value' => 'Concluído',
            'class' => 'btn-success',
            'text' => 'Finalizar chamado'
        ];
        return $data;
    } elseif(auth()->user()->isNot($ticket->owner)) {
        $data = [
            'value' => 'Encerrado',
            'class' => 'btn-warning',
            'text' => 'Encerrar chamado'
        ];
        return $data;
    } else {
        return false;
    }
}
