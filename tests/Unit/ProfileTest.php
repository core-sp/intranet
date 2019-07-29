<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_profile_can_be_created()
    {
        $this->withoutExceptionHandling();

        $profile = factory('App\Profile')->create();

        $this->assertDatabaseHas('profiles', [
            'name' => $profile->name
        ]);
    }
}
