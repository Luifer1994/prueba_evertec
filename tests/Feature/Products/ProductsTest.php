<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    public function test_product_list_success()
    {
        $response = $this->get('api/products-list');

        $response->assertStatus(200);
    }

    public function test_product_detail()
    {
        $product = Product::first();
        $response = $this->get('api/products-detail/' . $product->id);
        $response->assertStatus(200);
    }
}
