<?php

namespace App\Http\Repositories\DocumentTypes;

use App\Http\Repositories\BaseRepository;
use App\Models\DocumentType;

class DocumentTypeRepository extends BaseRepository
{

    const RELATIONSHIP = [];

    function __construct(DocumentType $client)
    {
        parent::__construct($client, self::RELATIONSHIP);
    }
}
