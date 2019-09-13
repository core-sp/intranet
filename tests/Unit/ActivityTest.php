<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivitiesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_activity_is_recorded_when_a_ticket_is_created()
    {
        $user = $this->signIn();

        $ticket = $this->post('/tickets', factory('App\Ticket')->raw());

        $ticket = \App\Ticket::first();

        $this->assertEquals(2, $ticket->activities()->count());
        $this->assertDatabaseHas('activities', [
            'ticket_id' => $ticket->id,
            'description' => '<strong>' . $user->name . '</strong> criou o chamado <i>"' . $ticket->title . '"</i>'
        ])->assertDatabaseHas('activities', [
            'ticket_id' => $ticket->id,
            'description' => '<strong>' . $user->name . '</strong> definiu como <i>' . $ticket->priority . '</i> a prioridade deste chamado'
        ]);
    }

    /** @test */
    function an_activity_is_recorded_when_a_user_assign_another_to_the_ticket()
    {
        $john = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $john->profile->id
        ]);

        $jane = factory('App\User')->create(['profile_id' => $ticket->profile->id]);

        $this->patch($ticket->path() . '/update-respondent', ['respondent_id' => $jane->id]);

        $this->assertEquals(3, $ticket->activities()->count());
        $this->assertDatabaseHas('activities', [
            'ticket_id' => $ticket->id,
            'description' => '<strong>' . $john->name . '</strong> atribuiu <i>' . $jane->name . '</i> ao chamado'
        ]);
    }

    /** @test */
    function an_activity_is_recorded_when_a_user_assign_another_profile_to_the_ticket()
    {
        $john = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $john->profile->id
        ]);

        $profile = factory('App\Profile')->create();

        $this->patch($ticket->path() . '/update-profile', ['profile_id' => $profile->id]);

        $this->assertEquals(3, $ticket->activities()->count());
        $this->assertDatabaseHas('activities', [
            'ticket_id' => $ticket->id,
            'description' => '<strong>' . $john->name . '</strong> atribuiu o chamado à área: <i>' . $profile->name . '</i>'
        ]);
    }

    /** @test */
    function an_activity_is_recorded_when_a_respondent_change_a_ticket_status()
    {
        $john = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $john->profile->id,
            'respondent_id' => $john->id
        ]);

        $this->patch($ticket->path() . '/update-status', ['status' => 'Encerrado']);

        $this->assertEquals(4, $ticket->activities()->count());
        $this->assertDatabaseHas('activities', [
            'ticket_id' => $ticket->id,
            'description' => '<strong>' . $john->name . '</strong> marcou o chamado como <i>' . $ticket->fresh()->status . '</i>'
        ]);
    }

    /** @test */
    function an_activity_is_recorded_when_an_owner_change_a_ticket_status()
    {
        $john = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'user_id' => $john->id
        ]);

        $this->patch($ticket->path() . '/update-status', ['status' => 'Concluído']);

        $this->assertEquals(4, $ticket->activities()->count());
        $this->assertDatabaseHas('activities', [
            'ticket_id' => $ticket->id,
            'description' => '<strong>' . $john->name . '</strong> marcou o chamado como <i>' . $ticket->fresh()->status . '</i>'
        ]);
    }

    /** @test */
    function creating_an_interaction_records_activity()
    {
        $john = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $john->profile->id,
            'respondent_id' => $john->id
        ]);

        $attributes = factory('App\Interaction')->raw([
            'ticket_id' => $ticket->id 
        ]);

        $this->post($ticket->path() . '/interactions', $attributes);

        $this->assertEquals(3, $ticket->activities()->count());
        $this->assertDatabaseHas('activities', [
            'ticket_id' => $ticket->id,
            'description' => '<strong>' . $john->name . '</strong> adicionou uma interação à este chamado'
        ]);
    }

    /** @test */
    function an_activity_is_recorded_when_user_add_an_attachment_to_a_ticket()
    {
        $john = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'user_id' => $john->id
        ]);

        $ticket->addAttachment('Texto.txt');

        $this->assertDatabaseHas('activities', [
            'ticket_id' => $ticket->id,
            'description' => '<strong>' . $john->name . '</strong> adicionou o anexo "Texto.txt" à este chamado'
        ]);
    }

    /** @test */
    function an_activity_is_recorded_when_user_add_an_attachment_to_a_interaction()
    {
        $john = $this->signIn();

        $ticket = factory('App\Ticket')->create([
            'profile_id' => $john->profile_id
        ]);

        $ticket->assignRespondent($john);

        $interaction = $ticket->addInteraction(factory('App\Interaction')->raw());

        $interaction->addAttachment('Corinthians.txt');

        $this->assertDatabaseHas('activities', [
            'ticket_id' => $ticket->id,
            'description' => '<strong>' . $john->name . '</strong> adicionou o anexo "Corinthians.txt" à este chamado'
        ]);
    }
}
