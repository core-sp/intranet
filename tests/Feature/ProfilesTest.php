<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_cannot_see_the_list_of_profiles()
    {
        $this->get('/profiles')->assertRedirect('/login');
    }

    /** @test */
    function guests_cannot_create_a_profile()
    {
        $this->get('/profiles/create')->assertRedirect('/login');
    }

    /** @test */
    function an_admin_can_create_a_profile()
    {
        $this->signInAsAdmin();

        $this->get('/profiles/create')->assertOk();

        $this->post('/profiles', ['name' => 'Teste']);

        $this->assertDatabaseHas('profiles', [
            'name' => 'Teste'
        ]);
    }

    /** @test */
    function a_non_admin_cannot_create_a_profile()
    {
        $this->signIn();

        $this->get('/profiles/create')->assertStatus(403);

        $this->post('/profiles', ['name' => 'Teste']);

        $this->assertDatabaseMissing('profiles', [
            'name' => 'Teste'
        ]);
    }

    /** @test */
    function a_user_can_see_completed_ticket_from_their_profile()
    {
        $this->withoutExceptionHandling();

        $john = $this->signIn();

        $profile = $john->profile;

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $profile->id,
            'status' => 'Concluído'
        ]);

        $this
            ->get($profile->path() . '/tickets-completed')
            ->assertOk()
            ->assertSee($ticket->title);
    }
}
