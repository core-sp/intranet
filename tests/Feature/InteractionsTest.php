<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InteractionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_cannot_create_interactions()
    {
        $ticket = factory('App\Ticket')->create();

        $this->get($ticket->path() . '/interactions/create')->assertRedirect('/login');

        $this->post($ticket->path() . '/interactions')->assertRedirect('/login');
    }

    /** @test */
    function unauthorized_users_cannot_create_interactions()
    {
        $this->signIn();

        $ticket = factory('App\Ticket')->create();

        $this->get($ticket->path() . '/interactions/create')->assertStatus(403);

        $attributes = factory('App\Interaction')->raw();

        $this->post($ticket->path() . '/interactions', $attributes)->assertStatus(403);

        $this->assertDatabaseMissing('interactions', [
            'content' => $attributes['content']
        ]);
    }

    /** @test */
    function tickets_owner_can_create_interactions()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'user_id' => $user->id
        ]);

        $attributes = factory('App\Interaction')->raw([
            'ticket_id' => $ticket->id
        ]);

        $this->post($ticket->path() . '/interactions', $attributes);

        $this->assertDatabaseHas('interactions', [
            'content' => $attributes['content']
        ]);

        $this
            ->get($ticket->path())
            ->assertSee($attributes['content']);
    }

    /** @test */
    function non_respondents_cannot_create_interactions()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create();

        $this->assertNotEquals($user->id, $ticket->respondent->id);

        $attributes = factory('App\Interaction')->raw();

        $this->post($ticket->path() . '/interactions', $attributes)->assertStatus(403);

        $this->assertDatabaseMissing('interactions', [
            'content' => $attributes['content']
        ]);
    }

    /** @test */
    function respondents_can_create_interactions_on_the_ticket()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile_id
        ]);

        $ticket->assignRespondent($user);

        $this->post($ticket->path() . '/interactions', $attributes = factory('App\Interaction')->raw());

        $this->assertDatabaseHas('interactions', [
            'content' => $attributes['content']
        ]);
    }

    /** @test */
    function respondents_cannot_interact_if_ticket_status_is_finished()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id,
            'status' => 'Encerrado'
        ]);

        $this
            ->post($ticket->path() . '/interactions', $attributes = factory('App\Interaction')->raw())
            ->assertStatus(403);

        $this->assertDatabaseMissing('interactions', [
            'content' => $attributes['content']
        ]);
    }

    /** @test */
    function an_owner_of_the_ticket_can_see_pending_response_status()
    {
        $john = $this->signIn();
        $jane = factory('App\User')->create();

        $ticket = factory('App\Ticket')->create([
            'user_id' => $john->id,
        ]);

        $ticket->assignRespondent($jane);

        factory('App\Interaction')->create([
            'ticket_id' => $ticket->id,
            'user_id' => $jane->id
        ]);

        $this->assertEquals($ticket->interactions->first()->user_id, $jane->id);

        $this->get('/tickets/created')->assertSee('NECESSITA INTERAÇÃO');
    }

    /** @test */
    function an_owner_of_the_ticket_can_see_awaiting_status()
    {
        $john = $this->signIn();
        $jane = factory('App\User')->create();

        $ticket = factory('App\Ticket')->create([
            'user_id' => $john->id
        ]);

        $ticket->assignRespondent($jane);

        factory('App\Interaction')->create([
            'ticket_id' => $ticket->id,
            'user_id' => $jane->id
        ]);

        $this->assertEquals($ticket->interactions->first()->user_id, $jane->id);

        factory('App\Interaction')->create([
            'ticket_id' => $ticket->id,
            'user_id' => $john->id,
            'created_at' => date("Y-m-d H:i:s", time() + 1)
        ]);

        $this->assertEquals($ticket->fresh()->interactions->first()->id, 2);
        $this->assertEquals($ticket->fresh()->interactions->first()->user_id, $john->id);

        $this->get('/tickets/created')->assertSee('AGUARDANDO INTERAÇÃO');
    }

    /** @test */
    /** @test */
    function respondents_can_see_pending_response_status()
    {
        $this->withoutExceptionHandling();
        $john = $this->signIn();
        $jane = factory('App\User')->create();

        $ticket = factory('App\Ticket')->create([
            'user_id' => $jane->id,
            'profile_id' => $john->profile->id
        ]);

        $ticket->assignRespondent($john);

        factory('App\Interaction')->create([
            'ticket_id' => $ticket->id,
            'user_id' => $john->id
        ]);

        $this->assertEquals($ticket->interactions->first()->user_id, $john->id);

        factory('App\Interaction')->create([
            'ticket_id' => $ticket->id,
            'user_id' => $jane->id,
            'created_at' => date("Y-m-d H:i:s", time() + 1)
        ]);

        $this->assertEquals($ticket->fresh()->interactions->first()->id, 2);
        $this->assertEquals($ticket->fresh()->interactions->first()->user_id, $jane->id);
        
        $this->get('/tickets')->assertSee('NECESSITA INTERAÇÃO');
    }

    /** @test */
    function respondents_can_see_awaiting_status()
    {
        $this->withoutExceptionHandling();
        $john = $this->signIn();
        $jane = factory('App\User')->create();

        $ticket = factory('App\Ticket')->create([
            'user_id' => $jane->id,
            'profile_id' => $john->profile->id
        ]);

        $ticket->assignRespondent($john);

        factory('App\Interaction')->create([
            'ticket_id' => $ticket->id,
            'user_id' => $john->id
        ]);

        $this->assertEquals($ticket->fresh()->interactions->first()->id, 1);
        $this->assertEquals($ticket->fresh()->interactions->first()->user_id, $john->id);

        $this->get('/tickets')->assertSee('AGUARDANDO INTERAÇÃO');
    }
}
