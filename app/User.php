<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Ticket;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean'
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    public function setProfile()
    {
        return $this->profile()->create(['name' => 'Teste']);
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket')->latest();
    }

    public function ticketsWithoutAttribution()
    {
        return Ticket::where('profile_id', $this->profile->id)
            ->whereNull('respondent_id')
            ->get();
    }

    public function ticketsFromProfile()
    {
        return Ticket::where('profile_id', $this->profile->id)->get();
    }

    public function ticketsResponding()
    {
        return Ticket::where('respondent_id', $this->id)->get();
    }

    public function isAdmin()
    {
        return auth()->user()->is_admin === true ? true : false;
    }

    public function isCoordinator()
    {
        return auth()->user()->is_coordinator === true ? true : false;
    }

    public function hasSameTicketProfile($ticket)
    {
        return $this->profile->id === $ticket->profile->id ? true : false;
    }
}
