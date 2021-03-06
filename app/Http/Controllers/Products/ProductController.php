<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Products\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productRepository;

    /**
     * Injet repository in mounte class.
     *
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *@param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {

            $limit = $request["limit"] ?? 20;
            return response()->json(["res" => true, "data" => $this->productRepository->index($limit)], 200);
        } catch (\Throwable $th) {
            return response()->json(["res" => false, "message" => $th->getMessage()], 400);
        }
    }

    /**
     * Detail product.
     *@param Int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $product = $this->productRepository->show($id);
        if (!$product) {
            return response()->json(["res" => false, "message" => "El registro no existe"], 404);
        }
        return response()->json(["res" => true, "message" => "ok", "data" => $product], 200);
    }
}
