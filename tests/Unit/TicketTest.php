<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_ticket_can_be_created()
    {
        $ticket = factory('App\Ticket')->create();

        $this->assertDatabaseHas('tickets', $ticket->toArray());
    }

    /** @test */
    function a_ticket_can_have_a_interaction()
    {
        $ticket = factory('App\Ticket')->create();

        $ticket->addInteraction($attributes = factory('App\Interaction')->raw());

        $this->assertEquals(1, $ticket->interactions->count());
        $this->assertDatabaseHas('interactions', [
            'content' => $attributes['content']
        ]);
    }

    /** @test */
    function a_ticket_may_have_multiple_interactions()
    {
        $ticket = factory('App\Ticket')->create();

        factory('App\Interaction', 2)->create([
            'ticket_id' => $ticket->id
        ]);

        $this->assertEquals(2, $ticket->interactions->count());
    }

    /** @test */
    function tickets_marked_as_completed_cannot_have_more_interactions()
    {
        $ticket = factory('App\Ticket')->create(['status' => 'Concluído']);

        $this->expectExceptionMessage('Não é possível adicionar uma nova interação à este chamado');

        $attributes = factory('App\Interaction')->raw(['ticket_id' => $ticket->id]);

        $ticket->addInteraction($attributes);
    }

    /** @test */
    function tickets_marked_as_completed_cannot_have_their_status_changed()
    {
        $ticket = factory('App\Ticket')->create(['status' => 'Concluído']);

        $this->expectExceptionMessage('Não é possível alterar o status deste chamado');

        $ticket->changeStatus('Em aberto');
    }
}
