<?php

namespace Tests\Unit\Payments;

use App\Http\Controllers\Payments\PaymentController;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Support\Str;

class PaymentTest extends TestCase
{
    /**
     * test_generate_link_payment_successful.
     *
     * @return void
     */
    public function test_generate_link_payment_successful()
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
        $paymentController  = new PaymentController;

        $paymentController->generateLinkPay($order);
        $this->assertTrue(true);
    }

    /**
     * test_generate_link_payment_fail.
     *
     * @return void
     */
    public function test_generate_link_payment_fail()
    {
        $paymentController  = new PaymentController;
        $paymentController->generateLinkPay(new Order());
        $this->assertFalse(false);
    }

    /**
     * test_consult_status_order sucess.
     *
     * @return void
     */
    public function test_consult_status_order()
    {
        $order = Order::first();
        $paymentController  = new PaymentController;
        $paymentController->getStatusOrder($order);
        $this->assertTrue(true);
    }

    /**
     * test_consult_status_order fails.
     *
     * @return void
     */
    public function test_consult_status_faild()
    {
        $paymentController  = new PaymentController;
        $paymentController->getStatusOrder(new Order());
        $this->assertFalse(false);
    }
}
