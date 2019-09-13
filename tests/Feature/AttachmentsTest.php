<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttachmentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_attachment_is_shown_at_the_ticket()
    {
        $this->signIn();

        $ticket = factory('App\Ticket')->create();

        $attachment = factory('App\Attachment')->create([
            'parent_type' => 'App\Ticket',
            'parent_id' => $ticket->id
        ]);

        $ticket->addAttachment($attachment->file);

        $this->get($ticket->path())->assertSee($attachment->file);
    }
}
