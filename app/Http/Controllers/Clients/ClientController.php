<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Clients\ClientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    private $clientRepository;

    /**
     * Injet repository in mounte class.
     *
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }


    /**
     * Get client by email.
     *@param $request type email address
     * @return JsonResponse
     */
    public function findEmail(Request $request): JsonResponse
    {
        try {
            $rules = ["email" => "required|email"];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $client = $this->clientRepository->findByEmail($request["email"]);
            if (!$client) {
                return response()->json(["res" => false, "message" => "El registro no existe"], 404);
            }
            return response()->json(["res" => true, "message" => "ok", "data" => $client], 200);
        } catch (\Throwable $th) {
            return response()->json(["res" => false, "message" => $th->getMessage()], 400);
        }
    }

    /**
     * List orders.
     *
     * @param  Request
     * @return JsonResponse
     */
    public function getOrders(Request $request): JsonResponse
    {
        try {
            $rules = [
                'email' => 'required|email|exists:clients,email'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $client = $this->clientRepository->findByEmail($request["email"]);

            $client["orders"] = $client->orders;

            if (!$client) {
                return response()->json(["res" => false, "message" => "El registro no existe"], 404);
            }
            return response()->json(["res" => true, "message" => "ok", "data" => $client], 200);
        } catch (\Throwable $th) {
            return response()->json(["res" => false, "message" => $th->getMessage()], 400);
        }
    }
}
