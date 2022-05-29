<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Products\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request): JsonResponse
    {
        try {

            $limit = $request["limit"] ?? 20;
            return response()->json(["res" => true, "data" => $this->productRepository->index($limit)], 200);
        } catch (\Throwable $th) {
            return response()->json(["res" => false, "message" => $th->getMessage()], 400);
        }
    }
}