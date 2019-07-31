<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function respondent()
    {
        return $this->belongsTo('App\User', 'respondent_id');
    }

    public function interactions()
    {
        return $this->hasMany('App\Interaction')->latest();
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

    public function assignRespondent($respondent_id)
    {
        $this->update(['respondent_id' => $respondent_id]);
    }
}
