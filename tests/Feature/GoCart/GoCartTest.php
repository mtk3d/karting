<?php

declare(strict_types=1);


namespace Tests\Feature\GoCart;


use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoCartTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateGoCart(): void
    {
        $response = $this->post('api/go-cart', [
            'name' => 'example go cart name',
            'description' => 'some description',
            'is_available' => false,
        ]);

        $response->assertCreated();

        $response = $this->get('api/go-cart/all');

        $response->assertJson([
            [
                'name' => 'example go cart name',
                'description' => 'some description',
                'is_available' => false
            ]
        ]);

        $id = $response->decodeResponseJson()[0]['id'];

        $this->assertDatabaseHas('resource_items', [
            'id' => $id
        ]);
    }

    public function testReserveGoCart(): void
    {
        $response = $this->post('api/go-cart', [
            'name' => 'example go cart name',
            'description' => 'some description',
            'is_available' => false,
        ]);

        $response->assertCreated();

        $id = $response->decodeResponseJson()['id'];

        $date = Carbon::create(2020, 3, 14, 12, 30);
        $from = $date->toISOString();
        $to = $date->addHour()->toISOString();

        $response = $this->post("api/availability/resources/$id/reservations", [
            'from' => $from,
            'to' => $to,
        ]);

        $response->assertOk();

        $response = $this->get("api/go-cart/$id/reservations");

        $response->assertJson([
            [
                'from' => $from,
                'to' => $to,
            ]
        ]);
    }
}
