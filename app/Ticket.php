<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Ticket extends Model
{
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

    public function respondents()
    {
        return $this->belongsToMany('App\User', 'ticket_respondents');
    }

    public function interactions()
    {
        return $this->hasMany('App\Interaction')->orderBy('created_at', 'DESC');
    }

    public function addInteraction($attributes)
    {
        $this->update(['status' => 'Em aberto']);
        
        return $this->interactions()->create($attributes);
    }

    public function changeStatus($string)
    {
        $this->update(['status' => $string]);
    }

    public function changeProfile($id)
    {
        $this->update(['profile_id' => $id]);
    }

    public function possibleRespondents()
    {
        $except = $this->respondents->pluck('id')->toArray();

        return \App\User::select('id', 'name')
            ->where('profile_id', $this->profile->id)
            ->get()
            ->except($except);
    }

    public function possibleProfiles()
    {
        return \App\Profile::select('id', 'name')
            ->where('id', '!=', $this->profile->id)
            ->get();
    }

    public function assignRespondents($users)
    {
        $users instanceof Collection ?? $users = $users->pluck('id')->toArray();

        return $this->respondents()->attach($users);
    }
}
