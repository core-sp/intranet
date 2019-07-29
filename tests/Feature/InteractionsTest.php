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
            'ticket_id' => $ticket->id,
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
    function non_owners_can_create_interactions_on_the_ticket()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id
        ]);

        $this->post($ticket->path() . '/interactions', $attributes = factory('App\Interaction')->raw());

        $this->assertDatabaseHas('interactions', [
            'content' => $attributes['content']
        ]);
    }

    /** @test */
    function non_owners_cannot_interact_if_ticket_status_is_finished()
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
}
