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
            ->get('/tickets/created')
            ->assertSee($ticket->title)
            ->assertSee($ticket->profile->name);

        $this
            ->get($ticket->path())
            ->assertSee($ticket->title)
            ->assertSee($ticket->user->name)
            ->assertSee($ticket->content);
    }

    /** @test */
    function created_and_completed_tickets_are_shown_correctly()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $ticket = factory('App\Ticket')->create(['user_id' => auth()->id()]);

        $this->patch($ticket->path() . '/update-status', ['status' => 'Concluído']);

        $this->get('/tickets/created-and-completed')->assertSee($ticket->title);
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
    function tickets_from_same_profile_as_user_are_shown_correctly()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id
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

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id
        ]);

        $ticket->assignRespondent($user);

        $this->assertTrue($user->isRespondent($ticket));

        $this
            ->patch($ticket->path() . '/update-status', ['status' => 'Encerrado'])
            ->assertRedirect($ticket->path());

        $this->assertEquals('Encerrado', $ticket->fresh()->status);
    }

    /** @test */
    function a_ticket_owner_can_complete_a_ticket()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create(['user_id' => $user->id]);

        $this
            ->patch($ticket->path() . '/update-status', ['status' => 'Concluído'])
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
    function a_user_with_the_same_profile_as_the_ticket_can_assign_another_user_to_be_respondent()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id
        ]);

        $userSameProfile = factory('App\User')->create(['profile_id' => $user->profile->id]);

        $this
            ->patch($ticket->path() . '/update-respondent', ['respondent_id' => $userSameProfile->id])
            ->assertRedirect($ticket->path());

        $this->assertEquals($userSameProfile->id, $ticket->fresh()->respondent->id);
    }

    /** @test */
    function a_user_cannot_assign_another_user_if_the_ticket_is_completed()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id,
            'status' => 'Concluído'
        ]);

        $userSameProfile = factory('App\User')->create(['profile_id' => $user->profile->id]);

        $this
            ->patch($ticket->path() . '/update-respondent', ['respondent_id' => $userSameProfile->id])
            ->assertStatus(403);

        $this->assertNotEquals($userSameProfile->id, $ticket->fresh()->respondent->id);
    }

    /** @test */
    function a_user_can_assign_itself_to_be_respondent()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id
        ]);

        $this->patch($ticket->path() . '/update-respondent', ['respondent_id' => $user->id])
            ->assertRedirect($ticket->path());

        $this->assertEquals($user->id, $ticket->fresh()->respondent->id);
    }

    /** @test */
    function a_user_with_the_same_profile_as_the_ticket_can_assign_it_to_other_profiles()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id
        ]);

        $profile = factory('App\Profile')->create();

        $this->patch($ticket->path() . '/update-profile', ['profile_id' => $profile->id])->assertRedirect('/');
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'profile_id' => $profile->id
        ]);
    }

    /** @test */
    function a_user_cannot_assign_a_ticket_to_other_profile_if_it_is_completed()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id,
            'status' => 'Concluído'
        ]);

        $profile = factory('App\Profile')->create();

        $this->patch($ticket->path() . '/update-profile', ['profile_id' => $profile->id])->assertStatus(403);
        $this->assertDatabaseMissing('tickets', [
            'id' => $ticket->id,
            'profile_id' => $profile->id
        ]);
    }

    /** @test */
    function a_user_cant_assign_the_ticket_profile_with_its_own_profile()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id
        ]);

        $this->patch($ticket->path() . '/update-profile', ['profile_id' => $ticket->profile->id])->assertStatus(403);
        $this->assertEquals($ticket->profile->id, $user->profile->id);
    }

    /** @test */
    function unauthorized_users_cannot_assign_other_profiles_to_the_ticket()
    {
        $this->signIn();

        $ticket = factory('App\Ticket')->create();

        $profile = factory('App\Profile')->create();

        $this->patch($ticket->path() . '/update-profile', ['profile_id' => $profile->id])->assertStatus(403);
        $this->assertDatabaseMissing('tickets', [
            'id' => $ticket->id,
            'profile_id' => $profile->id
        ]);
    }

    /** @test */
    function a_respondent_can_assign_other_user_to_be_respondent()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id,
            'respondent_id' => $user->id
        ]);

        $otherUser = factory('App\User')->create(['profile_id' => $ticket->profile->id]);

        $this->patch($ticket->path() . '/update-respondent', ['respondent_id' => $otherUser->id]);

        $this->assertEquals($otherUser->id, $ticket->fresh()->respondent->id);
    }

    /** @test */
    function a_user_from_a_different_profile_cannot_assign_someone_to_be_respondent()
    {
        $this->signIn();

        $ticket = factory('App\Ticket')->create();

        $someUser = factory('App\User')->create(['profile_id' => $ticket->profile->id]);

        $this->patch($ticket->path() . '/update-respondent', ['respondent_id' => $someUser->id]);

        $this->assertNotEquals($someUser->id, $ticket->fresh()->respondent->id);
    }

    /** @test */
    function finishing_a_ticket_generates_an_interaction()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $user->profile->id
        ]);

        $ticket->assignRespondent($user);

        $this->patch($ticket->path() . '/update-status', ['status' => 'Encerrado']);

        $this->assertDatabaseHas('interactions', [
            'ticket_id' => $ticket->id,
            'content' => '<p>Chamado finalizado.</p>'
        ]);
    }

    /** @test */
    function completing_a_ticket_generates_an_interaction()
    {
        $user = $this->signIn();

        $ticket = factory('App\Ticket')->create(['user_id' => $user->id]);

        $this->patch($ticket->path() . '/update-status', ['status' => 'Concluído']);
     
        $this->assertDatabaseHas('interactions', [
            'ticket_id' => $ticket->id,
            'content' => '<p>Chamado concluído.</p>'
        ]);
    }
}
