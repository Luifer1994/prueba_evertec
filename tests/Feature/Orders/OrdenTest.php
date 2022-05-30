<?php

namespace Tests\Feature\Orders;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Support\Str;

class OrdenTest extends TestCase
{

    public function test_create_new_order()
    {
        $product =  Product::first();
        $client =  Client::first();
        if (!$client) {
            $client = Client::create(
                [
                    'document_type_id' => 1,
                    'document_number' => 123456,
                    'name' => "Test",
                    'last_name' => "Testing",
                    'email' => Str::random(10) . "@test.com",
                    'phone' => "323232",
                ]
            );
        }
        $data = [
            "client" => $client,
            "products" => [
                [
                    "id" => $product->id,
                    "quantity" => 14
                ]
            ]
        ];
        $response = $this->post('/api/order-create', $data);
        $response->assertStatus(200);
    }

    public function test_create_new_order_fail()
    {
        $data = [];
        $response = $this->post('/api/order-create', $data);
        $response->assertStatus(400);
    }

    public function test_show_order_success()
    {
        $order      = Order::first();
        $product    =  Product::first();
        $client     = Client::first();

        if (!$client) {
            $client = Client::create(
                [
                    'document_type_id' => 1,
                    'document_number' => 123456,
                    'name' => "Test",
                    'last_name' => "Testing",
                    'email' => Str::random(10) . "@test.com",
                    'phone' => "323232",
                ]
            );
        }
        if (!$order) {
            $order = Order::create([
                'client_id' => $client->id,
                'total' => $product->price * 14,
                'uuid' => Str::uuid(),
                "client" => $client,
                "products" => [
                    [
                        "id" => $product->id,
                        "quantity" => 14
                    ]
                ]
            ]);
        }
        $response = $this->get('/api/order-show/' . $order->uuid);
        $response->assertStatus(200);
    }

    public function test_show_order_fail()
    {
        $id = 0;
        $response = $this->get('/api/order-show/' . $id);
        $response->assertStatus(404);
    }

    public function test_order_retry_payment_success()
    {
        $order      = Order::first();
        $product    =  Product::first();
        $client     = Client::first();

        if (!$client) {
            $client = Client::create(
                [
                    'document_type_id' => 1,
                    'document_number' => 123456,
                    'name' => "Test",
                    'last_name' => "Testing",
                    'email' => Str::random(10) . "@test.com",
                    'phone' => "323232",
                ]
            );
        }
        if (!$order) {
            $order = Order::create([
                "client" => $client,
                "products" => [
                    [
                        "id" => $product->id,
                        "quantity" => 14
                    ]
                ]
            ]);
        }
        $response = $this->get('/api/order-retry-payment/' . $order->uuid);
        $response->assertStatus(200);
    }
}
