<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_ticket_can_be_created()
    {
        $this->withoutExceptionHandling();

        $ticket = factory('App\Ticket')->create();

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'title' => $ticket->title
        ]);
    }

    /** @test */
    function a_ticket_can_have_a_interaction()
    {
        $this->signIn();

        $ticket = factory('App\Ticket')->create();

        factory('App\Interaction')->create([
            'ticket_id' => $ticket->id,
            'content' => 'Teste de conteúdo'
        ]);

        $this->assertEquals(1, $ticket->interactions->count());
        $this->assertDatabaseHas('interactions', [
            'content' => 'Teste de conteúdo'
        ]);
    }

    /** @test */
    function a_ticket_may_have_multiple_interactions()
    {
        $this->signIn();

        $ticket = factory('App\Ticket')->create();

        factory('App\Interaction', 2)->create([
            'ticket_id' => $ticket->id
        ]);

        $this->assertEquals(2, $ticket->interactions->count());
    }

    /** @test */
    function a_ticket_must_be_associated_with_a_profile()
    {
        $this->signIn();

        $attributes = factory('App\Ticket')->raw(['profile_id' => '']);

        $this->post('/tickets', $attributes)->assertSessionHasErrors('profile_id');
    }

    /** @test */
    function a_ticket_can_have_one_respondent()
    {
        $user = factory('App\User')->create();

        $ticket = factory('App\Ticket')->create(['profile_id' => $user->profile->id]);

        $ticket->assignRespondent($user);

        $this->assertEquals($user->name, $ticket->respondent->name);
    }

    /** @test */
    function a_ticket_cannot_have_a_respondent_from_different_profile()
    {
        $user = factory('App\User')->create();

        $ticket = factory('App\Ticket')->create();
        
        $ticket->assignRespondent($user);

        $this->assertDatabaseMissing('tickets', ['respondent_id' => $user->id]);
    }
}
