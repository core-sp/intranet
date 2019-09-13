<?php

namespace App\Traits;

use App\Activity;
use App\User;

trait TicketUpdates {

    public function changeStatus($string)
    {
        $this->update(['status' => $string]);
    }

    public function changeProfile($id)
    {
        $this->update(['profile_id' => $id]);
    }

    public function assignRespondent(User $user)
    {
        return $user->hasSameTicketProfile($this) ? $this->update(['respondent_id' => $user->id]) : false;
    }

    public function assignRespondentById($id)
    {
        $this->update(['respondent_id' => $id]);
    }

    protected function mergeAttributes($attributes)
    {
        return array_merge([
            'ticket_id' => $this->id,
            'user_id' => auth()->id(),
            'content' => '<p>Resposta padrão.</p>'
        ], $attributes);
    }

    public function addInteraction($attributes, $status = 'Em aberto')
    {
        $merge = $this->mergeAttributes($attributes);

        if($status !== null) {
            $this->update(['status' => 'Em aberto']);
        }
        
        return $this->interactions()->create($merge);

        request('fileName') !== null ? $this->interaction->addAttachment(request('fileName')) : '';
    }

    public function recordActivity($message)
    {
        Activity::create([
            'ticket_id' => $this->id,
            'description' => $message
        ]);
    }
}