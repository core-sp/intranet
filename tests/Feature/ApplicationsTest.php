<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeneralsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_cannot_see_the_homepage()
    {
        $this->get('/')->assertRedirect('login');
    }

    /** @test */
    function logged_in_users_can_see_the_homepage()
    {
        $this->signIn();

        $this->get('/')->assertOk();
    }
}
