<?php

declare(strict_types=1);


namespace Tests\Feature\Track;


use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class TrackTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateTrack(): void
    {
        $response = $this->createWithdrawnTrack();

        $id = $response->decodeResponseJson()['id'];

        $response = $this->get('api/track/all');

        $response->assertJson([
            [
                'name' => 'example go cart name',
                'description' => 'some description',
                'slots' => 5,
                'is_available' => false
            ]
        ]);

        $this->assertDatabaseHas('resource_items', [
            'id' => $id,
            'is_available' => false
        ]);
    }

    public function testReserveTrack(): void
    {
        $response = $this->createTrack();

        $id = $response->decodeResponseJson()['id'];

        $date = Carbon::create(2020, 3, 14, 12, 30);
        $from = $date->toISOString();
        $to = $date->addHour()->toISOString();

        $response = $this->post("api/availability/resources/$id/reservations", [
            'from' => $from,
            'to' => $to,
        ]);

        $response->assertOk();

        $response = $this->get("api/track/$id/reservations");

        $response->assertJson([
            [
                'from' => $from,
                'to' => $to,
            ]
        ]);
    }

    public function testWithdrawTrack(): void
    {
        $response = $this->createTrack();

        $id = $response->decodeResponseJson()['id'];

        $response = $this->patch("api/availability/resources/$id", [
            'is_available' => false
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('resource_items', [
            'id' => $id,
            'is_available' => false
        ]);
    }

    public function testTurnOnTrack(): void
    {
        $response = $this->createWithdrawnTrack();

        $id = $response->decodeResponseJson()['id'];

        $response = $this->patch("api/availability/resources/$id", [
            'is_available' => true
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('resource_items', [
            'id' => $id,
            'is_available' => true
        ]);
    }

    private function createTrack(): TestResponse
    {
        $response = $this->post('api/track', [
            'name' => 'example go cart name',
            'description' => 'some description',
            'slots' => 5,
            'is_available' => true,
        ]);

        $response->assertCreated();

        return $response;
    }

    private function createWithdrawnTrack(): TestResponse
    {
        $response = $this->post('api/track', [
            'name' => 'example go cart name',
            'description' => 'some description',
            'slots' => 5,
            'is_available' => false,
        ]);

        $response->assertCreated();

        return $response;
    }
}
