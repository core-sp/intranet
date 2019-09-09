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
        return $this->hasMany('App\Ticket')->where('status', '!=', 'Concluído')->orderBy('updated_at', 'DESC');
    }

    public function ticketsCount()
    {
        return $this->tickets()->count();
    }

    public function completedTickets()
    {
        return $this->hasMany('App\Ticket')->where('status', '=', 'Concluído')->orderBy('updated_at', 'DESC')->paginate(10);
    }
}
