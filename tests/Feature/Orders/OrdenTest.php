<?php

namespace Tests\Feature\Orders;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;

class OrdenTest extends TestCase
{

    public function test_create_new_order()
    {
        $product =  Product::first();
        $data = [
            "client" => Client::first(),
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
        $order = Order::first();
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
        $order = Order::first();
        $response = $this->get('/api/order-retry-payment/' . $order->uuid);
        $response->assertStatus(200);
    }
}
