<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Payments\PaymentController;
use App\Http\Repositories\Orders\OrderRepository;
use App\Http\Repositories\Clients\ClientRepository;
use App\Http\Repositories\Orders\OrderLineRepository;
use App\Http\Repositories\Products\ProductRepository;
use App\Http\Requests\Orders\CreateOrderRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderLine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{

    private $orderRepository;
    private $clientRepository;
    private $productRepository;
    private $orderLineRepository;

    public function __construct(OrderRepository $orderRepository, ClientRepository $clientRepository, ProductRepository $productRepository, OrderLineRepository $orderLineRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->clientRepository = $clientRepository;
        $this->productRepository = $productRepository;
        $this->orderLineRepository = $orderLineRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOrderRequest $request) //: JsonResponse
    {

        DB::beginTransaction();

        try {

            if ($request->client["id"]) {
                $request["client_id"] = $request->client["id"];
            } else {

                $client                 = new Client($request->client);
                $client                 = $this->clientRepository->save($client);
                $request["client_id"]   = $client->id;
            }

            $request["total"] = 0;
            $request["uuid"] = Str::uuid();
            foreach ($request->products as $product) {

                $getProduct         = $this->productRepository->show($product["id"]);
                $request["total"]   += $getProduct->price * $product["quantity"];
            }

            $newOrder = new Order($request->all());
            $newOrder = $this->orderRepository->save($newOrder);

            foreach ($request->products as $product) {

                $dataOrderLine =  [
                    "product_id" => $product["id"],
                    "quantity"   => $product["quantity"],
                    "order_id"   => $newOrder->id
                ];

                $orderLine = new OrderLine($dataOrderLine);
                $this->orderLineRepository->save($orderLine);
            }

            DB::commit();
            $paymentController = new PaymentController;
            $payment = $paymentController->generateLinkPay($newOrder);
            $newOrder["url_payment"] = $payment;

            return response()->json(["res" => true, "message" => "Orden creada con éxito", "data" => $newOrder], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(["res" => false, "message" => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($uuid): JsonResponse
    {
        try {

            $order = $this->orderRepository->getUuid($uuid);
            if (!$order) {
                return response()->json(["res" => false, "message" => "El registro no existe"], 404);
            }
            $paymentController = new PaymentController;
            $order =   $paymentController->getStatusOrder($order);

            return response()->json(["res" => true, "message" => "ok", "data" => $order], 200);
        } catch (\Throwable $th) {
            return response()->json(["res" => false, "message" => $th->getMessage()], 400);
        }
    }

    /**
     * reintent payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function retryPayment($uuid)
    {
        $order = $this->orderRepository->getUuid($uuid);
        $paymentController = new PaymentController;
        $payment = $paymentController->generateLinkPay($order);
        $order["url_payment"] = $payment;

        return response()->json(["res" => true, "message" => "Orden creada con éxito", "data" => $order], 200);
    }
}
