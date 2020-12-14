<?php

declare(strict_types=1);


namespace Tests\Feature\GoCart;


use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class GoCartTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateGoCart(): void
    {
        $response = $this->createWithdrawnGoCart();

        $id = $response->decodeResponseJson()['id'];

        $response = $this->get('api/go-cart/all');

        $response->assertJson([
            [
                'name' => 'example go cart name',
                'description' => 'some description',
                'is_available' => false
            ]
        ]);

        $this->assertDatabaseHas('resource_items', [
            'id' => $id,
            'is_available' => false
        ]);
    }

    public function testReserveGoCart(): void
    {
        $response = $this->createGoCart();

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

    public function testWithdrawGoCart(): void
    {
        $response = $this->createGoCart();

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

    public function testTurnOnGoCart(): void
    {
        $response = $this->createWithdrawnGoCart();

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

    private function createGoCart(): TestResponse
    {
        $response = $this->post('api/go-cart', [
            'name' => 'example go cart name',
            'description' => 'some description',
            'is_available' => true,
        ]);

        $response->assertCreated();

        return $response;
    }

    private function createWithdrawnGoCart(): TestResponse
    {
        $response = $this->post('api/go-cart', [
            'name' => 'example go cart name',
            'description' => 'some description',
            'is_available' => false,
        ]);

        $response->assertCreated();

        return $response;
    }
}
