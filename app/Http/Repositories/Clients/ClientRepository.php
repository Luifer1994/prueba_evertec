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


    public function findByEmail(string $email)
    {
        return $this->model->whereEmail($email)->with('document_type')->first();
    }

}
