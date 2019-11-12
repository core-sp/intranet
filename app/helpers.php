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

function onlyDate($date)
{
    return $date->format('d\/m\/Y');
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
    if(auth()->user()->can('close', $ticket) && $ticket->status !== 'Concluído') {
        return [
            'value' => 'Concluído',
            'class' => 'btn-success',
            'text' => 'Finalizar chamado'
        ];
    } elseif(auth()->user()->can('finish', $ticket) && $ticket->status !== 'Encerrado') {
        return [
            'value' => 'Encerrado',
            'class' => 'btn-warning',
            'text' => 'Encerrar chamado'
        ];
    } else {
        return false;
    }
}

function bgPriority($priority)
{
    switch ($priority) {
        case 'Muito Baixa':
        case 'Baixa':
            return 'bg-baixa';
        break;
        
        case 'Média':
            return 'bg-media';
        break;

        case 'Alta':
        case 'Muito Alta':
            return 'bg-alta';
        break;
    }
}

function removeBlankLines($str)
{
    $newStr = preg_replace('/<([^>\s]+)[^>]*>(?:\s*(?:<br \/>|&nbsp;|&thinsp;|&ensp;|&emsp;|&#8201;|&#8194;|&#8195;)\s*)*<\/\1>/', '', $str);
    $newStr = preg_replace('/(<br\ ?\/?>)+/', '<br>', $newStr);

    return $newStr;
}