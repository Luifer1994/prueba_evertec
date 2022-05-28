<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
