<?php

namespace App\Http\Repositories\Clients;

use App\Http\Repositories\BaseRepository;
use App\Models\Client;

class ClientRepository extends BaseRepository
{

    const RELATIONSHIP = ['document_type'];


    function __construct(Client $client)
    {
        parent::__construct($client, self::RELATIONSHIP);
    }

}
