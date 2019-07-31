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
        $this->signIn();

        $this->get('/tickets')->assertOk();

        $response = $this
            ->post('/tickets', $attributes = factory('App\Ticket')->raw())
            ->assertRedirect('/tickets/1');

        $this->assertDatabaseHas('tickets', [
            'title' => $attributes['title']
        ]);
    }

    /** @test */
    function created_tickets_are_shown_correctly()
    {
        $this->signIn();

        $ticket = factory('App\Ticket')->create(['user_id' => auth()->id()]);

        $this
            ->get('/tickets')
            ->assertSee($ticket->title)
            ->assertSee($ticket->profile->name);

        $this
            ->get($ticket->path())
            ->assertSee($ticket->title)
            ->assertSee($ticket->user->name)
            ->assertSee($ticket->content);
    }

    /** @test */
    function a_ticket_can_have_a_profile_associated_with_it()
    {
        $profile = factory('App\Profile')->create();

        $ticket = factory('App\Ticket')->create(['profile_id' => $profile->id]);

        $this->assertEquals(1, $ticket->profile->id);
    }

    /** @test */
    function a_ticket_requires_a_title()
    {
        $this->signIn();

        $attributes = factory('App\Ticket')->raw(['title' => '']);

        $this->post('/tickets', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    function a_ticket_requires_a_priority()
    {
        $this->signIn();

        $attributes = factory('App\Ticket')->raw(['priority' => '']);

        $this->post('/tickets', $attributes)->assertSessionHasErrors('priority');
    }

    /** @test */
    function a_ticket_requires_a_content()
    {
        $this->signIn();

        $attributes = factory('App\Ticket')->raw(['content' => '']);

        $this->post('/tickets', $attributes)->assertSessionHasErrors('content');
    }

    /** @test */
    function the_ticket_content_must_have_at_least_10_characters()
    {
        $this->signIn();

        $attributes = factory('App\Ticket')->raw(['content' => 'small']);

        $this->post('/tickets', $attributes)->assertSessionHasErrors('content');
    }

    /** @test */
    function unauthorized_users_cannot_view_the_ticket()
    {
        $this->signIn();

        $ticket = factory('App\Ticket')->create();

        $this->get($ticket->path())->assertStatus(403);
    }

    /** @test */
    function tickets_from_same_profile_as_user_are_shown_correctly()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id,
            'respondent_id' => null
        ]);

        $this
            ->get('/tickets')
            ->assertSee($ticket->title);

        $this
            ->get($ticket->path())
            ->assertOk()
            ->assertSee($ticket->title)
            ->assertSee($ticket->user->name)
            ->assertSee($ticket->content);
    }
    
    /** @test */
    function respondents_can_finish_a_ticket()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create(['respondent_id' => $user->profile->id]);

        $this
            ->patch($ticket->path(), ['status' => 'Encerrado'])
            ->assertRedirect($ticket->path());

        $this->assertEquals('Encerrado', $ticket->fresh()->status);
    }

    /** @test */
    function a_ticket_owner_can_complete_a_ticket()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create(['user_id' => $user->id]);

        $this
            ->patch($ticket->path(), ['status' => 'Concluído'])
            ->assertRedirect($ticket->path());

        $this->assertEquals('Concluído', $ticket->fresh()->status);
    }

    /** @test */
    function an_owner_cannot_finish_a_ticket()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create(['user_id' => $user->id]);

        $this->patch($ticket->path(), ['status' => 'Encerrado']);
        
        $this->assertNotEquals('Encerrado', $ticket->fresh()->status);
    }

    /** @test */
    function non_owners_cannot_mark_a_ticket_as_complete()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create(['profile_id' => $user->profile->id]);

        $this->patch($ticket->path(), ['status' => 'Concluído']);

        $this->assertNotEquals('Concluído', $ticket->fresh()->status);
    }

    /** @test */
    function a_user_with_the_same_profile_as_the_ticket_can_assign_another_user_from_the_same_profile_to_be_respondent()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id,
            'respondent_id' => null
        ]);

        $userSameProfile = factory('App\User')->create(['profile_id' => $user->profile->id]);

        $this
            ->patch($ticket->path(), ['respondent_id' => $userSameProfile->id])
            ->assertRedirect($ticket->path());

        $this->assertEquals($userSameProfile->id, $ticket->fresh()->respondent_id);
    }

    /** @test */
    function a_user_can_assign_itself_to_be_respondent()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id,
            'respondent_id' => null
        ]);

        $this->patch($ticket->path(), ['respondent_id' => $user->id]);

        $this->assertEquals($user->id, $ticket->fresh()->respondent_id);
    }
}
