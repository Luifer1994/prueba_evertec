<?php

namespace App\Http\Controllers\DocumentTypes;

use App\Http\Controllers\Controller;
use App\Http\Repositories\DocumentTypes\DocumentTypeRepository;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    private $documentTypeRepository;

    public function __construct(DocumentTypeRepository $documentTypeRepository)
    {
        $this->documentTypeRepository = $documentTypeRepository;
    }

    public function index()
    {
        $documentTypes = $this->documentTypeRepository->index(20);

        return response()->json(['res' => true, 'data' => $documentTypes], 200);
    }
}
