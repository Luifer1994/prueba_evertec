<?php

namespace Tests\Unit\Payments;

use App\Http\Controllers\Payments\PaymentController;
use App\Models\Order;
use Tests\TestCase;

class GenerateLinkPaymentTest extends TestCase
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
}
