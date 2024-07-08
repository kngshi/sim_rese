<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

    }

    public function testReservationDateMustBeInTheFuture()
    {
        $response = $this->post('/reservation', [
            'date' => '2024-07-05',
            'time' => '12:00',
            'number' => 3,
        ]);

        $response->assertSessionHasErrors(['date' => '予約日は今日以降の日付を選択してください。']);
    }
}
