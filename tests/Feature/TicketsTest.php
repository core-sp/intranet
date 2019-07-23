<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_cannot_see_the_tickets_dashboard_page()
    {
        $this->get('/tickets')->assertRedirect('login');
    }

    /** @test */
    function guests_cannot_see_the_create_tickets_page()
    {
        $this->get('/tickets/create')->assertRedirect('login');
    }

    /** @test */
    function a_user_can_view_the_create_tickets_page()
    {
        $this->signIn();
        
        $this->get('/tickets/create')->assertOk();
    }

    /** @test */
    function guests_cannot_create_a_ticket()
    {
        $attributes = factory('App\Ticket')->raw();

        $this->post('/tickets', $attributes)->assertRedirect('login');
    }

    /** @test */
    function a_user_can_create_a_ticket()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('tickets', $ticket->toArray());
    }

    /** @test */
    function created_tickets_are_shown_on_the_tickets_dashboard()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create(['user_id' => $user->id]);

        $this->get('/tickets')->assertSee($ticket->title);
    }

    /** @test */
    // function a_ticket_must_have_a_profile_associated_with()
    // {

    // }
}
