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
        $ticket = factory('App\Ticket')->create();

        $this->assertDatabaseHas('tickets', $ticket->toArray());
    }

    /** @test */
    function a_ticket_can_have_a_interaction()
    {
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
    function a_ticket_may_have_one_respondent()
    {
        $ticket = factory('App\Ticket')->create();

        $user = factory('App\User')->create();

        $ticket->assignRespondents($user->id);

        $this->assertEquals(1, count($ticket->respondents));
    }

    /** @test */
    function a_ticket_may_have_several_respondents()
    {
        $ticket = factory('App\Ticket')->create();

        $users = factory('App\User', 2)->create();

        $ticket->assignRespondents($users);
        
        $this->assertEquals(2, count($ticket->respondents));
    }
}
