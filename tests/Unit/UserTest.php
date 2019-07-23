<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_must_have_a_profile()
    {
        $this->withoutExceptionHandling();

        $profile = factory('App\Profile')->create(['name' => 'CTI']);

        $user = factory('App\User')->create(['profile_id' => $profile->id]);

        $this->assertEquals('CTI', $user->profile->name);
    }
}
