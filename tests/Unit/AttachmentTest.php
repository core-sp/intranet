<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttachmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_attachment_can_be_created_and_bounded_to_a_ticket()
    {
        $this->signIn();

        $ticket = factory('App\Ticket')->create();

        $attachment = factory('App\Attachment')->create([
            'parent_type' => 'App\Ticket',
            'parent_id' => $ticket->id
        ]);

        $ticket->addAttachment($attachment->file);

        $this->assertDatabaseHas('attachments',[
            'parent_type' => 'App\Ticket',
            'parent_id' => $ticket->id,
            'file' => $attachment->file
        ]);
    }

    /** @test */
    function an_attachment_can_be_created_and_bounded_to_an_interaction()
    {
        $this->signInAsAdmin();
        
        $ticket = factory('App\Ticket')->create();

        $interaction = factory('App\Interaction')->create([
            'ticket_id' => $ticket->id
        ]);

        $attachment = factory('App\Attachment')->create([
            'parent_type' => 'App\Interaction',
            'parent_id' => $interaction->id
        ]);

        $interaction->addAttachment($attachment->file);

        $this->assertDatabaseHas('attachments',[
            'parent_type' => 'App\Interaction',
            'parent_id' => $interaction->id,
            'file' => $attachment->file
        ]);
    }
}
