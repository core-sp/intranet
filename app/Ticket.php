<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\TicketUpdates;

class Ticket extends Model
{
    use TicketUpdates;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function owner()
    {
        return $this->user();
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    public function path()
    {
        return '/tickets/' . $this->id;
    }

    public function respondent()
    {
        return $this->belongsTo('App\User');
    }

    public function interactions()
    {
        return $this->hasMany('App\Interaction')->orderBy('created_at', 'DESC');
    }

    public function activities()
    {
        return $this->hasMany('App\Activity')->latest();
    }

    public function possibleRespondents()
    {
        
        isset($this->respondent->id) ? $respondentId = $this->respondent->id : $respondentId = 0;

        return \App\User::select('id', 'name')
            ->where('id', '!=', $respondentId)
            ->where('profile_id', $this->profile->id)
            ->get();
    }

    public function possibleProfiles()
    {
        return \App\Profile::select('id', 'name')
            ->where('id', '!=', $this->profile->id)
            ->get();
    }
}
