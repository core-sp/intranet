<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_create_a_user()
    {
        $this->signInAsAdmin();
        
        $this->get('/users/create')->assertOk();

        $user = factory('App\User')->raw([
            'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);

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
    function a_user_requires_a_name()
    {
        $this->signInAsAdmin();

        $user = factory('App\User')->raw([
            'name' => '',
            'email' => 'email@email.com'
        ]);

        $this->post('/users', $user)->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('users', ['email' => 'email@email.com']);
    }

    /** @test */
    function a_user_requires_an_email()
    {
        $this->signInAsAdmin();

        $user = factory('App\User')->raw([
            'name' => 'João Maria',
            'email' => ''
        ]);

        $this->post('/users', $user)->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', ['name' => 'João Maria']);
    }

    /** @test */
    function a_user_requires_a_password()
    {
        $this->signInAsAdmin();

        $user = factory('App\User')->raw([
            'name' => 'João Maria',
            'password' => ''
        ]);

        $this->post('/users', $user)->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['name' => 'João Maria']);
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

    /** @test */
    function a_user_can_update_its_own_basic_infos()
    {
        $john = $this->signIn();

        $attributes = [
            'name' => 'Mike Myers',
            'email' => 'mike@email.com',
        ];

        $this->get($john->path() . '/edit')->assertOk();

        $this->patch($john->path(), $attributes);

        $this->assertDatabaseHas('users', $attributes);
        $this->assertDatabaseMissing('users', ['name' => $john->name]);
    }

    /** @test */
    function guests_cannot_update_users_infos()
    {
        $john = factory('App\User')->create();
        
        $this->get($john->path() . '/edit')->assertRedirect('/login');

        $attributes = [
            'name' => 'Mike Myers',
            'email' => 'mike@email.com',
        ];

        $this->patch($john->path(), $attributes)->assertRedirect('/login');
        $this->assertDatabaseMissing('users', ['name' => 'Mike Myers']);
    }

    /** @test */
    function a_user_cannot_update_other_users_info()
    {
        $this->signIn();

        $john = factory('App\User')->create();

        $attributes = [
            'name' => 'Mike Myers',
            'email' => 'mike@email.com',
        ];

        $this->get($john->path() . '/edit')->assertStatus(403);

        $this->patch($john->path(), $attributes);

        $this->assertDatabaseHas('users', ['name' => $john->name]);
        $this->assertDatabaseMissing('users', $attributes);
    }

    /** @test */
    function a_user_can_update_its_password()
    {
        $user = $this->signIn();

        $this->get($user->path() . '/change-password')->assertOk();

        $password = [
            'password' => 'NovaSenha102030@'
        ];

        $this->patch($user->path() . '/change-password', $password)->assertRedirect('/');

        $this->assertTrue(Hash::check('NovaSenha102030@', $user->fresh()->password));
    }

    /** @test */
    function an_admin_can_change_a_users_password()
    {
        $this->signInAsAdmin();

        $user = factory('App\User')->create();

        $this->get($user->path() . '/change-password')->assertOk();

        $password = [
            'password' => 'NovaSenha102030@'
        ];

        $this->patch($user->path() . '/change-password', $password)->assertRedirect('/');

        $this->assertTrue(Hash::check('NovaSenha102030@', $user->fresh()->password));
    }

    /** @test */
    function non_admin_cannot_change_other_users_password()
    {
        $this->signIn();

        $user = factory('App\User')->create();

        $this->get($user->path() . '/change-password')->assertForbidden();

        $password = [
            'password' => 'NovaSenha102030@'
        ];

        $this->patch($user->path() . '/change-password', $password);

        $this->assertFalse(Hash::check('NovaSenha102030@', $user->fresh()->password));
    }

    /** @test */
    function an_admin_can_delete_a_user()
    {
        $this->signInAsAdmin();

        $user = factory('App\User')->create();

        $this->assertDatabaseHas('users', ['id' => $user->id]);

        $this->delete('/users/' . $user->id);

        $this->assertNotNull($user->fresh()->deleted_at);
    }

    /** @test */
    function non_admins_cannot_delete_a_user()
    {
        $this->signInAsAdmin();

        $user = factory('App\User')->create();

        $this->assertDatabaseHas('users', ['id' => $user->id]);

        $this->signIn();

        $this->delete('/users/' . $user->id)->assertStatus(403);

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
