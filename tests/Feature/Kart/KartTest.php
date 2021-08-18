<?php

declare(strict_types=1);


namespace Tests\Feature\Kart;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class KartTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateKart(): void
    {
        $this->createDisabledKart();

        $response = $this->get('api/kart');

        $response->assertJson([
            [
                'uuid' => '81cf2b8f-a004-4995-a990-84c87470a139',
                'name' => 'Kart 01',
                'description' => 'Super fast motor kart',
                'enabled' => false,
                'price' => '$10.00'
            ]
        ]);

        $this->assertDatabaseHas('resource_items', [
            'uuid' => '81cf2b8f-a004-4995-a990-84c87470a139',
            'enabled' => false
        ]);
    }

    public function testDisableKart(): void
    {
        $this->createKart();

        $response = $this->patch("api/kart/81cf2b8f-a004-4995-a990-84c87470a139/state", [
            'enabled' => false
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('resource_items', [
            'uuid' => '81cf2b8f-a004-4995-a990-84c87470a139',
            'enabled' => false
        ]);
    }

    public function testEnableKart(): void
    {
        $this->createDisabledKart();

        $response = $this->patch("api/kart/81cf2b8f-a004-4995-a990-84c87470a139/state", [
            'enabled' => true
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('resource_items', [
            'uuid' => '81cf2b8f-a004-4995-a990-84c87470a139',
            'enabled' => true
        ]);
    }

    private function createKart(): TestResponse
    {
        $response = $this->post('api/kart', [
            'uuid' => '81cf2b8f-a004-4995-a990-84c87470a139',
            'name' => 'Kart 01',
            'description' => 'Super fast motor kart',
            'enabled' => true,
            'price' => 1000
        ]);

        $response->assertCreated();

        return $response;
    }

    private function createDisabledKart(): TestResponse
    {
        $response = $this->post('api/kart', [
            'uuid' => '81cf2b8f-a004-4995-a990-84c87470a139',
            'name' => 'Kart 01',
            'description' => 'Super fast motor kart',
            'enabled' => false,
            'price' => 1000
        ]);

        $response->assertCreated();

        return $response;
    }
}
