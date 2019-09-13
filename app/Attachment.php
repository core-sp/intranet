<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    protected $guarded = [];

    public function parent()
    {
        return $this->morphTo();
    }

    public function recordActivity($message)
    {
        $ticketId = $this->parent_type === 'App\Ticket' ? $this->parent_id : $this->parent->ticket_id;
        \App\Activity::create([
            'ticket_id' => $ticketId,
            'description' => $message,
            'created_at' => date('Y-m-d H:i:s', strtotime('+1 second'))
        ]);
    }

    public function storagePath()
    {
        return asset('/storage/anexos/' . $this->file);
    }
}
