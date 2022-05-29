<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Orders\OrderRepository;
use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{

    public function generateLinkPay(Order $order)
    {

        try {

            $seed =  date('c');
            $once = base64_encode($order->uuid);
            $key = $_ENV["KEY_PAYMENT"];

            $tranKey = base64_encode(sha1($order->uuid . $seed . $key, true));
            $client = new Client();
            /* return [
                "login" => $_ENV["LOGIN_PAYMENT"],
                "seed" => $seed,
                "nonce" => $once,
                "tranKey" => $tranKey
            ]; */
            $response = $client->post(
                'https://dev.placetopay.com/redirection/api/session',
                ['json' => [
                    "locale" => "es_CO",
                    "auth" => [
                        "login" => $_ENV["LOGIN_PAYMENT"],
                        "seed" => $seed,
                        "nonce" => $once,
                        "tranKey" => $tranKey
                    ],
                    "payment" => [
                        "reference" => $order->id,
                        "description" => "Pedido N- " . $order->id,
                        "amount" => [
                            "currency" => "COP",
                            "total" => $order->total,
                        ],
                        "allowPartial" => false
                    ],
                    "expiration" => $order->created_at->addHours(2),
                    "returnUrl" => "https://dnetix.co/p2p/client?ref=" . $order->id,
                    "ipAddress" => "127.0.0.1",
                    "userAgent" => "PlacetoPay Sandbox"
                ]]
            );

            $response = json_decode($response->getBody(), true);

            $order->payment_id = $response["requestId"];
            $order->update();

            return $response['processUrl']; //access key

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
