<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function path()
    {
        return '/profiles/' . $this->id;
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket')->where('status', '!=', 'Concluído')->latest();
    }

    public function completedTickets()
    {
        return $this->hasMany('App\Ticket')->where('status', '=', 'Concluído')->paginate(10);
    }
}
