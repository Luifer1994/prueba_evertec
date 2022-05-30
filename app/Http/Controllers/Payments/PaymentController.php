<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Orders\OrderRepository;
use App\Models\Order;
use Carbon\Carbon;
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

            if (!$order->payment_id) {
                $dateExpired = $order->created_at->addHours(5);
            } else {
                $dateExpired = Carbon::now()->addHours(5);
            }

            $tranKey = base64_encode(sha1($order->uuid . $seed . $key, true));
            $client = new Client();
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
                    "expiration" => $dateExpired,
                    "returnUrl" => $_ENV["FRONT_URL_RETURN"] . $order->uuid,
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

    public function getStatusOrder(Order $order)
    {

        try {

            $seed =  date('c');
            $once = base64_encode($order->uuid);
            $key = $_ENV["KEY_PAYMENT"];

            $tranKey = base64_encode(sha1($order->uuid . $seed . $key, true));
            $client = new Client();
            $response = $client->post(
                'https://dev.placetopay.com/redirection/api/session/' . $order->payment_id,
                ['json' => [
                    "auth" => [
                        "login"     => $_ENV["LOGIN_PAYMENT"],
                        "seed"      => $seed,
                        "nonce"     => $once,
                        "tranKey"   => $tranKey
                    ]
                ]]
            );

            $response       = json_decode($response->getBody(), true);

            //return $response;
            $order->status = $this->returnStatus($response["status"]["status"]);
            $order->update();
            return $order;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function returnStatus(String $status)
    {
        switch ($status) {
            case 'FAILED':
                return "REJECTED";
                break;
            case 'APPROVED';
                return "PAYED";
                break;
            case "APPROVED_PARTIAL";
                return "PENDING";
                break;
            case 'REJECTED';
                return "REJECTED";
                break;
            case 'PENDING';
                return "PENDING";
                break;
            case 'PENDING_VALIDATION';
                return "PENDING";
                break;
            case 'REFUNDED';
                return "REJECTED";
            default:
                break;
        }
    }
}
