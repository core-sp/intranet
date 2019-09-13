<?php

namespace App\Observers;

use App\Attachment;

class AttachmentObserver
{
    public function created(Attachment $attachment)
    {
        $attachment->recordActivity('<strong>' . auth()->user()->name . '</strong> adicionou o anexo "' . $attachment->file . '" à este chamado');
    }
}
