<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    protected $guarded = [];
    protected $touches = ['ticket'];
    
    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function recordActivity($message)
    {
        $this->ticket->activities()->create([
            'description' => $message
        ]);
    }
}
