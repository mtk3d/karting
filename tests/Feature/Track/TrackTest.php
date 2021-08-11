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
        $this->createDisabledTrack();

        $response = $this->get('api/track');

        $response->assertJson([
            [
                'uuid' => 'f9ba5871-2ada-40e9-8305-0de9143249a7',
                'name' => 'Track 01',
                'description' => 'Super slow track',
                'enabled' => false,
                'slots' => 8,
                'price' => '10.0'
            ]
        ]);

        $this->assertDatabaseHas('resource_items', [
            'uuid' => 'f9ba5871-2ada-40e9-8305-0de9143249a7',
            'enabled' => false
        ]);
    }

    public function testDisableTrack(): void
    {
        $this->createTrack();

        $response = $this->patch("api/track/f9ba5871-2ada-40e9-8305-0de9143249a7/state", [
            'enabled' => false
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('resource_items', [
            'uuid' => 'f9ba5871-2ada-40e9-8305-0de9143249a7',
            'enabled' => false
        ]);
    }

    public function testEnableTrack(): void
    {
        $this->createDisabledTrack();

        $response = $this->patch("api/track/f9ba5871-2ada-40e9-8305-0de9143249a7/state", [
            'enabled' => true
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('resource_items', [
            'uuid' => 'f9ba5871-2ada-40e9-8305-0de9143249a7',
            'enabled' => true
        ]);
    }

    private function createTrack(): TestResponse
    {
        $response = $this->post('api/track', [
            'uuid' => 'f9ba5871-2ada-40e9-8305-0de9143249a7',
            'name' => 'Track 01',
            'description' => 'Super slow track',
            'enabled' => true,
            'slots' => 8,
            'price' => 10
        ]);

        $response->assertCreated();

        return $response;
    }

    private function createDisabledTrack(): TestResponse
    {
        $response = $this->post('api/track', [
            'uuid' => 'f9ba5871-2ada-40e9-8305-0de9143249a7',
            'name' => 'Track 01',
            'description' => 'Super slow track',
            'enabled' => false,
            'slots' => 8,
            'price' => 10
        ]);

        $response->assertCreated();

        return $response;
    }
}
