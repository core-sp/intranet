<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_create_a_user()
    {
        $this->signInAsAdmin();
        
        $this->get('/users/create')->assertOk();

        $user = factory('App\User')->raw();

        $this->post('/users', $user);

        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email']
        ]);
    }

    /** @test */
    function a_non_admin_cannot_create_a_user()
    {
        $this->signIn();
        
        $this->get('/users/create')->assertStatus(403);

        $attributes = factory('App\User')->raw();

        $this
            ->post('/users', $attributes)
            ->assertStatus(403);

        $this->assertDatabaseMissing('users', $attributes);
    }

    /** @test */
    function an_admin_can_see_the_list_of_users()
    {
        $users = factory('App\User', 5)->create();

        $this->signInAsAdmin();

        $this->get('/users')->assertOk();
    }

    /** @test */
    function guests_cannot_see_the_list_of_users()
    {
        $users = factory('App\User', 5)->create();

        $this->signIn();

        $this->get('/users')->assertStatus(403);
    }
}
