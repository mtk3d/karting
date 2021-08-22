<?php

declare(strict_types=1);

namespace Tests\Feature\Reservation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateKart(): void
    {
        $this->createKarts();
        $this->createTrack();

        $response = $this->post('api/reservation', [
            'uuid' => '81cf2b8d-a004-4995-a990-84c87480a257',
            'karts_ids' => [
                '81cf2b8f-a004-4995-a990-84c87470a139',
                '81cf2b8f-a004-4995-a990-84c87470a140',
            ],
            'track_id' => 'f9ba5871-2ada-40e9-8305-0de9143249a7',
            'from' => '2021-08-21 11:00:00',
            'to' => '2021-08-21 12:00:00',
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('reservations', [
            'uuid' => '81cf2b8d-a004-4995-a990-84c87480a257',
            'status' => 'confirmed',
            'from' => '2021-08-21 11:00:00',
            'to' => '2021-08-21 12:00:00'
        ]);

        $this->assertDatabaseHas('reservations_read_model', [
            'uuid' => '81cf2b8d-a004-4995-a990-84c87480a257',
            'status' => 'confirmed',
            'from' => '2021-08-21 11:00:00',
            'to' => '2021-08-21 12:00:00',
            'price' => '$25.00'
        ]);
    }

    private function createKarts(): TestResponse
    {
        $response = $this->post('api/kart', [
            'uuid' => '81cf2b8f-a004-4995-a990-84c87470a139',
            'name' => 'Kart 01',
            'description' => 'Super fast motor kart',
            'enabled' => true,
            'price' => 1000
        ]);

        $response->assertCreated();

        $response = $this->post('api/kart', [
            'uuid' => '81cf2b8f-a004-4995-a990-84c87470a140',
            'name' => 'Kart 02',
            'description' => 'Super slow motor kart',
            'enabled' => true,
            'price' => 500
        ]);

        $response->assertCreated();

        return $response;
    }

    private function createTrack(): TestResponse
    {
        $response = $this->post('api/track', [
            'uuid' => 'f9ba5871-2ada-40e9-8305-0de9143249a7',
            'name' => 'Track 01',
            'description' => 'Super slow track',
            'enabled' => true,
            'slots' => 4,
            'price' => 1000
        ]);

        $response->assertCreated();

        return $response;
    }
}
