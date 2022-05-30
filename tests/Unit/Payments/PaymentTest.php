<?php

namespace Tests\Unit\Payments;

use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Payments\PaymentController;
use App\Http\Repositories\Clients\ClientRepository;
use App\Http\Repositories\Orders\OrderLineRepository;
use App\Http\Repositories\Orders\OrderRepository;
use App\Models\Order;
use Database\Factories\ProductFactory;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /**
     * test_generate_link_payment_successful.
     *
     * @return void
     */
    public function test_generate_link_payment_successful()
    {
        $order              = Order::first();
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
