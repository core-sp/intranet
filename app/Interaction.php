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

    public function attachment()
    {
        return $this->morphMany('App\Attachment', 'parent');
    }

    public function addAttachment($file)
    {
        \App\Attachment::create([
            'parent_type' => get_class($this),
            'parent_id' => $this->id,
            'file' => $file
        ]);
    }
}
