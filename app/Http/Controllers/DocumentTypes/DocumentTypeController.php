<?php

namespace App\Http\Controllers\DocumentTypes;

use App\Http\Controllers\Controller;
use App\Http\Repositories\DocumentTypes\DocumentTypeRepository;
use Illuminate\Http\JsonResponse;

class DocumentTypeController extends Controller
{

    private $documentTypeRepository;

    /**
     * Injet repository in mounte class.
     *
     */
    public function __construct(DocumentTypeRepository $documentTypeRepository)
    {
        $this->documentTypeRepository = $documentTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {

            $documentTypes = $this->documentTypeRepository->index(20);
            return response()->json(['res' => true, 'data' => $documentTypes], 200);
        } catch (\Throwable $th) {
            return response()->json(["res" => false, "message" => $th->getMessage()], 400);
        }
    }
}
