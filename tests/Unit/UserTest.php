<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_be_created()
    {
        $user = factory('App\User')->create();

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    /** @test */
    function a_user_can_have_a_profile()
    {
        $user = factory('App\User')->create();

        $this->assertEquals(1, $user->profile->count());
    }
}
