<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }
}
