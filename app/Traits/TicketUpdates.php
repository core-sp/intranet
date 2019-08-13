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

    public function addInteraction($attributes)
    {
        $this->update(['status' => 'Em aberto']);
        
        return $this->interactions()->create($attributes);
    }

    public function recordActivity($message)
    {
        Activity::create([
            'ticket_id' => $this->id,
            'description' => $message
        ]);
    }
}