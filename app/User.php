<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Ticket;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

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

    public function tickets()
    {
        return $this->hasMany('App\Ticket')->orderBy('updated_at', 'DESC');
    }

    public function ticketsCount()
    {
        return $this->tickets()->where('status', '!=', 'Concluído')->count();
    }

    public function respondentTickets()
    {
        return $this->hasMany('App\Ticket', 'respondent_id')->orderBy('updated_at', 'DESC');
    }

    public function respondentTicketsWithPagination()
    {
        return $this->respondentTickets()->where('status', '!=', 'Concluído')->paginate(20);
    }

    public function respondentTicketsCount()
    {
        return $this->respondentTicketsWithPagination()->count();
    }

    public function ticketsFromProfile()
    {
        return Ticket::where('profile_id', $this->profile->id)
            ->where('status', '!=', 'Concluído')
            ->take(20)
            ->get();
    }

    public function isAdmin()
    {
        return auth()->user()->is_admin === true ? true : false;
    }

    public function isCoordinator()
    {
        return auth()->user()->is_coordinator === true ? true : false;
    }

    public function isRespondent($ticket)
    {
        return $ticket->respondent !== null && $this->id === $ticket->respondent->id ? true : false;
    }

    public function hasSameTicketProfile($ticket)
    {
        return $this->profile->id === $ticket->profile->id ? true : false;
    }

    public function path()
    {
        return '/users/' . $this->id;
    }

    public function searchUserTickets($search)
    {
        $searches = preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY);

        return $this
            ->tickets()
            ->where('user_id', 'LIKE', auth()->id())
            ->where(function($query) use($searches){
                foreach($searches as $search) {
                    $query->where(function($qubo) use ($search){
                        $qubo->where('title', 'LIKE', '%'.$search.'%')
                            ->orWhere('content', 'LIKE', '%'.htmlentities($search).'%')
                            ->orWhere('status', 'LIKE', '%'.$search.'%');
                    });
                }
            })->orderBy('updated_at', 'DESC')
            ->limit(50)
            ->get();
    }
}
